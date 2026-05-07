<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        return view('profile.show');
    }

    /**
     * Update name & email.
     */
    public function update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        $user->update($data);

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Change password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', function ($attr, $val, $fail) {
                if (!Hash::check($val, auth()->user()->password)) {
                    $fail('Current password is incorrect.');
                }
            }],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        auth()->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password changed successfully.');
    }

    /**
     * Upload & update avatar.
     */
    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
        ]);

        $user = auth()->user();

        // Delete old avatar
        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $path]);

        return back()->with('success', 'Profile photo updated.');
    }
}