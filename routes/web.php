<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SignalementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.form');
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:admin,agent_municipal')->group(function (): void {
        Route::post('/signalements/{signalement}/status', [SignalementController::class, 'updateStatus'])
            ->name('signalements.status.update');
    });

    Route::middleware('role:admin')->group(function (): void {
        Route::post('/signalements/{signalement}/assign-agent', [SignalementController::class, 'assignAgent'])
            ->name('signalements.assign.agent');
    });



    Route::middleware('role:citoyen')->group(function (): void {
        Route::get('/signalements/create', [SignalementController::class, 'create'])->name('signalements.create');
        Route::post('/signalements', [SignalementController::class, 'store'])->name('signalements.store');
        Route::get('/signalements/{signalement}/edit', [SignalementController::class, 'edit'])->name('signalements.edit');
        Route::put('/signalements/{signalement}', [SignalementController::class, 'update'])->name('signalements.update');
        Route::delete('/signalements/{signalement}', [SignalementController::class, 'destroy'])->name('signalements.destroy');
    });
    Route::middleware('role:citoyen,admin,agent_municipal')->group(function (): void {
        Route::get('/signalements', [SignalementController::class, 'index'])->name('signalements.index');
        Route::get('/signalements/{signalement}', [SignalementController::class, 'show'])->name('signalements.show');
    });
});
