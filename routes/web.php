<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes (Web Views)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('auth.login');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('auth.register');
});

// Dashboard (Public route - JavaScript will handle auth verification)
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
