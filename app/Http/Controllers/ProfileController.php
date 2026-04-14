<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{

    public function show(): View
    {
        $user = Auth::user();
        $name = trim((string) $user->name);
        $parts = preg_split('/\s+/', $name, 2) ?: [];

        return view('profile', [
            'user' => $user,
            'firstName' => $parts[0] ?? '',
            'lastName' => $parts[1] ?? '',
        ]);
    }
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:60'],
            'last_name' => ['nullable', 'string', 'max:60'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'localisation' => ['nullable', 'string', 'max:120'],
            'biography' => ['nullable', 'string', 'max:500'],
        ]);

        $user->name = trim($validated['first_name'] . ' ' . ($validated['last_name'] ?? ''));
        $user->email = $validated['email'];
        $user->phone = $validated['phone'] ?: null;
        $user->localisation = $validated['localisation'] ?: null;
        $user->biography = $validated['biography'] ?: null;
        $user->save();

        return redirect()->route('profile.show')->with('status', 'Profil mis a jour avec succes.');
    }
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        Auth::logout();
        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('status', 'Compte supprime avec succes.');
    }
}
