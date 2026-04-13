<?php

namespace App\Http\Controllers;

use App\Models\Signalement;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $user = $request->user()->load('role');

        $signalements = collect();

        if ($user->hasRole('citoyen')) {
            $signalements = Signalement::query()
                ->with(['category', 'photos'])
                ->latest()
                ->get();
        }

        return view('dashboard', [
            'user' => $user,
            'signalements' => $signalements,
        ]);
    }
}
