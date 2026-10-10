<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

// Route Auth bawaan Tugas 1
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// Route Tugas 2
Route::get('/', [CartController::class, 'index'])->name('cart.index');
Route::get('/keranjang', [CartController::class, 'keranjang'])->name('cart.keranjang');
Route::post('/keranjang/tambah/{id}', [CartController::class, 'tambah'])->name('cart.tambah');
Route::post('/keranjang/ubah/{id}', [CartController::class, 'ubahJumlah'])->name('cart.ubah');
Route::post('/keranjang/hapus/{id}', [CartController::class, 'hapus'])->name('cart.hapus');
Route::post('/keranjang/kosongkan', [CartController::class, 'kosongkan'])->name('cart.kosongkan');