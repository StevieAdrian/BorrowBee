<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
    public function show(User $user)
    {
        $authUser = auth()->user();

        $isFollowing = false;
        if ($authUser && $authUser->id !== $user->id) {
            $isFollowing = $authUser->followingUser()->where('followed_id', $user->id)->exists();
        }

        $reviews = $user->reviews()->with('book')->latest()->paginate(5);

        return view('view-profile', compact('user', 'isFollowing', 'reviews'));
    }

    public function profile()
    {
        return view('profile', [
            'user' => auth()->user(),
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'avatar' => 'nullable|image|max:2048',
            'password' => [
                'nullable',
                'confirmed',
                Password::min(12)
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
            ]
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
        $user->password = bcrypt($request->password);
    }


        if ($request->input('delete_avatar') === '1' && $user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->avatar = null;
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    public function privacy()
    {
        return view('privacy', [
            'user' => auth()->user(),
        ]);
    }

    public function updatePrivacy(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:12|confirmed',
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password updated successfully!');
    }

    public function toggleFollow($id)
    {
        $target = User::findOrFail($id);
        $user = Auth::user();

        if ($user->isFollowingUser($target)) {
            $user->followingUser()->detach($target->id);
        } else {
            $user->followingUser()->attach($target->id);
        }

        return back();
    }
}
