<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

// 1. Katalog Utama (Bisa dilihat tanpa login)
Route::get('/', [ShopController::class, 'index'])->name('katalog');

// 2. Route Guest (Hanya untuk pengguna yang BELUM login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// 3. Route Auth (Wajib login untuk aktivitas pembelian & transaksi)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Keranjang Belanja
    Route::get('/keranjang', [ShopController::class, 'keranjang'])->name('cart.index');
    Route::post('/keranjang/tambah/{id}', [ShopController::class, 'tambah'])->name('cart.tambah');
    Route::post('/keranjang/ubah/{id}', [ShopController::class, 'ubahJumlah'])->name('cart.ubah');
    Route::post('/keranjang/hapus/{id}', [ShopController::class, 'hapus'])->name('cart.hapus');
    Route::post('/keranjang/kosongkan', [ShopController::class, 'kosongkan'])->name('cart.kosongkan');

    // Checkout
    Route::get('/checkout', [ShopController::class, 'checkoutView'])->name('checkout.view');
    Route::post('/checkout', [ShopController::class, 'checkoutProcess'])->name('checkout.process');

    // Riwayat Pesanan
    Route::get('/riwayat', [ShopController::class, 'riwayat'])->name('order.history');
});