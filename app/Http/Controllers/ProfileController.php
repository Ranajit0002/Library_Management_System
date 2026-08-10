<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $user = $request->user();
        if ($user) {
            $user->load('member');
        }
        return view('profile.edit', ['user' => $user]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        if (!$user) {
            return Redirect::route('login');
        }

        DB::transaction(function () use ($request, $user) {
            $user->fill($request->safe()->only(['name', 'email']));

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            if ($request->boolean('remove_avatar')) {
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $user->avatar = null;
            } elseif ($request->hasFile('avatar')) {
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $path = $request->file('avatar')->store('avatars', 'public');
                $user->avatar = $path;
            }

            $user->save();
        });

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        if (!$user) {
            return Redirect::to('/');
        }

        if ($user->member) {
            $hasActiveBorrowings = $user->member->bookIssues()
                ->whereIn('status', ['issued', 'borrowed', 'pending'])
                ->exists();

            if ($hasActiveBorrowings) {
                return back()->with('error', 'Cannot delete account while you have un-returned borrowed books.');
            }
        }

        DB::transaction(function () use ($user) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            if ($user->member) {
                $user->member->delete();
            }

            $user->delete();
        });

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}