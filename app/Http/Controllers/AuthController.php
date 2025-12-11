<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Carbon\Carbon;

class AuthController extends Controller
{
    //
    public function loginForm()
    {
        return view('auth.login');
    }
    
    public function registerForm()
    {
        return view('auth.register');
    }

    public function otpForm()
    {
        return view('auth.otp');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return back()->with('error', 'Incorrect email or password.')->withInput();
        }

        $request->session()->regenerate();

        if(Auth::user()->role_id === 2){
            return redirect()->intended('admin/dashboard');
        }

        return redirect()->intended('home');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        $otp = rand(100000, 999999);

        session([
            'register_data' => [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ],
            'otp_code' => $otp,
            'otp_email' => $validated['email'],
            'otp_expire' => now()->addMinutes(5),
        ]);

        Mail::to($validated['email'])->send(new OtpMail($otp));

        return redirect()->route('otp.form')->with('success', 'Check your email for the OTP code.');
    }

    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required']);

        if (!session('otp_code')) {
            return back()->with('error', 'OTP expired. Please register again.');
        }

        if (Carbon::now()->gt(session('otp_expire'))) {
            return back()->with('error', 'OTP expired. Please register again.');
        }

        if ($request->otp != session('otp_code')) {
            return back()->with('error', 'Invalid OTP.');
        }

        $data = session('register_data');

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role_id' => 1,
        ]);
     
        session()->forget(['register_data', 'otp_code', 'otp_expires_at']);
        Auth::login($user);

        return redirect('home')->with('success', 'Register successful!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
