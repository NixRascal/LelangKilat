<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\AuctionController;

Route::get('daftar', [AuthController::class,'showoRegisterForm'])->name('register.form');
Route::post('daftar', [AuthController::class,'register'])->name('register');

Route::get('masuk', [AuthController::class,'showLoginForm'])->name('login.form');
Route::post('masuk', [AuthController::class,'login'])->name('login');

Route::post('keluar', [AuthController::class,'logout'])->name('logout');


Route::get('/home', [HomeController::class, 'index'])->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
});

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('/auctions', [HomeController::class,'index'])->name('auctions.index');

Route::get('/auctions', [HomeController::class,'index'])->name('auctions.show');

Route::get('/auctions/{category}', [AuctionController::class, 'index'])->name('auctions.index');

Route::get('/auctions/{category?}', [AuctionController::class, 'index'])->name('auctions.index');

Route::get('/auctions/create', [AuctionController::class, 'create'])->name('auctions.create');
Route::get('/auctions/participated', [AuctionController::class, 'create'])->name('auctions.participated');
Route::get('/auctions/mine', [AuctionController::class, 'create'])->name('auctions.mine');