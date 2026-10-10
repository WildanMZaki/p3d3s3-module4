<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

// Redirect root ke /login
Route::get('/', function () {
    return redirect()->route('login');
});

// Route untuk yang BELUM login (guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::POST('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::POST('/logout', [AuthController::class, 'logout'])->name('logout');
});
