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
}
