<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        if (in_array($user->role, ['admin', 'petugas'])) {
            return view('admin.profile.edit', [
                'user' => $user,
            ]);
        }

        return view('profile.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's full profile (Basic Info + Security).
     */
    public function fullUpdate(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ];

        // Only validate password if one of the password fields is filled
        if ($request->filled('current_password') || $request->filled('password')) {
            $rules['current_password'] = ['required', 'current_password'];
            $rules['password'] = ['required', 'confirmed', Password::defaults()];
        }

        $validated = $request->validate($rules);

        // Update Basic Info
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Update Password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Semua data profil admin berhasil diperbarui.');
        } elseif ($user->role === 'petugas') {
            return redirect()->route('petugas.dashboard')->with('success', 'Semua data profil petugas berhasil diperbarui.');
        }

        return back()->with('status', 'profile-updated');
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        $user = $request->user();
        if ($user->role === 'admin') {
            return Redirect::route('admin.dashboard')->with('success', 'Profil admin berhasil diperbarui.');
        } elseif ($user->role === 'petugas') {
            return Redirect::route('petugas.dashboard')->with('success', 'Profil petugas berhasil diperbarui.');
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
