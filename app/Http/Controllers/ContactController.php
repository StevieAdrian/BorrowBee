<?php

namespace App\Http\Controllers;

use App\Mail\ContactUsAdminMail;
use App\Mail\ContactUsMail;
use App\Mail\ContactUsUserMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    function send(Request $request)
    {
       $request->validate([
        'message' => 'required|string'
    ]);

    $user = Auth::user();

    $admins = User::where('role_id', '2')->pluck('email')->toArray();

    Mail::to($admins[0])
        ->cc(array_slice($admins, 1))
        ->send(new ContactUsAdminMail($user, $request->message));

    Mail::to($user->email)
        ->send(new ContactUsUserMail($user));

    return back()->with('success', 'Your message has been sent successfully.');
    }
}
