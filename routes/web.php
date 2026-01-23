<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SuperAdminDashboardController;

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

// Super Admin Dashboard
Route::get('/dashboard/superadmin', [SuperAdminDashboardController::class, 'index'])->name('dashboard.superadmin');

// Sales Dashboard
Route::get('/dashboard/sales', function () {
    return view('dashboard-sales');
})->name('dashboard.sales');

// Affiliate Dashboard
Route::get('/dashboard/affiliate', function () {
    return view('dashboard-affiliate');
})->name('dashboard.affiliate');

// Finance Dashboard
Route::get('/dashboard/finance', function () {
    return view('dashboard-finance');
})->name('dashboard.finance');

