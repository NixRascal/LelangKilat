<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\AuctionController;

// Auth routes
Route::get('daftar', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('daftar', [AuthController::class, 'register'])->name('register');

Route::get('masuk', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('masuk', [AuthController::class, 'login'])->name('login');

Route::post('keluar', [AuthController::class, 'logout'])->name('logout');

// Home
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index'])->middleware('auth');

// Wallet (hanya untuk user login)
Route::middleware('auth')->group(function () {
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
});

// Auction routes
Route::prefix('auctions')->group(function () {
    Route::get('/', [AuctionController::class, 'index'])->name('auctions.index');
    Route::get('/create', [AuctionController::class, 'create'])->name('auctions.create');
    Route::get('/participated', [AuctionController::class, 'participated'])->name('auctions.participated');
    Route::get('/mine', [AuctionController::class, 'mine'])->name('auctions.mine');
    Route::get('/{category}', [AuctionController::class, 'index'])->name('auctions.category');
    Route::get('/{category}', [AuctionController::class, 'index'])->name('auctions.show');
});

// routes/web.php
Route::get('/admin/dashboard', [AdminController::class,'checking'])->name('admin.dashboard')->middleware('auth');
Route::get('/admin/dashboard', [AdminController::class,'dashboard'])->name('admin.dashboard');
Route::get('/admin/pengguna', [AdminController::class,'user'])->name('admin.user');
Route::get('/admin/lelang', [AdminController::class,'auction'])->name('admin.auction');
Route::get('/admin/lelang/edit/{id}', [AdminController::class,'editAuction'])->name('auctions.edit');
Route::put('/admin/lelang/update/{id}', [AdminController::class, 'updateAuction'])->name('auctions.update');
Route::delete('/admin/lelang/delete/{id}', [AdminController::class,'destoryAuction'])->name('auctions.destroy');