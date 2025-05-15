<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BidController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\AuctionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Redirect root URL (/) ke halaman login
Route::redirect('/', '/home');

// 2. Authentication Routes
Route::get('/masuk', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/masuk', [AuthController::class, 'login'])->name('login');
Route::post('/keluar', [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/daftar', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/daftar', [AuthController::class, 'register'])->name('register');
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index')->middleware('auth');
Route::get('/cari', [AuctionController::class, 'search'])->name('search');

// 5. Auction Routes
Route::get('/lelang/create', [AuctionController::class, 'create'])->name('auctions.create')->middleware('auth');
Route::post('/lelang', [AuctionController::class, 'store'])->name('auctions.store')->middleware('auth');
Route::get('/lelang/participated', [AuctionController::class, 'participated'])->name('auctions.participated')->middleware('auth');
Route::get('/lelang/mine', [AuctionController::class, 'mine'])->name('auctions.mine')->middleware('auth');
Route::get('/lelang/kategori/{slug}', [AuctionController::class, 'category'])->name('auctions.category');
Route::get('/lelang/{auction}', [AuctionController::class, 'show'])->name('auctions.show');
Route::post('/bid/{auction}', [BidController::class, 'store'])->name('bid.place')->middleware('auth');
    
// 6. Admin Routes (hanya authenticated)
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('auth');

Route::get('/admin/pengguna', [AdminController::class, 'user'])->name('admin.user')->middleware('auth');
Route::get('/admin/pengguna/edit/{id}', [AdminController::class, 'editUser'])->name('admin.user.edit')->middleware('auth');
Route::put('/admin/pengguna/update/{id}', [AdminController::class, 'updateUser'])->name('admin.user.update')->middleware('auth');
Route::delete('/admin/pengguna/delete/{id}', [AdminController::class, 'destroyUser'])->name('admin.user.destroy')->middleware('auth');

Route::get('/admin/lelang', [AdminController::class, 'auction'])->name('admin.auction')->middleware('auth');
Route::get('/admin/lelang/edit/{id}', [AdminController::class, 'editAuction'])->name('admin.auction.edit')->middleware('auth');
Route::put('/admin/lelang/update/{id}', [AdminController::class, 'updateAuction'])->name('admin.auction.update')->middleware('auth');
Route::delete('/admin/lelang/delete/{id}', [AdminController::class, 'destoryAuction'])->name('admin.auction.destroy')->middleware('auth');

Route::get('/admin/akunadmin', [AdminController::class, 'admins'])->name('admin.admins')->middleware('auth');
Route::get('/admin/akunadmin/edit/{id}', [AdminController::class, 'editAdmins'])->name('admin.admins.edit')->middleware('auth');
Route::put('/admin/akunadmin/update/{id}', [AdminController::class, 'updateAdmins'])->name('admin.admins.update')->middleware('auth');
Route::get('/admin/akun/tambah', [AdminController::class, 'createAdmin'])->name('admin.admins.create');
Route::post('/admin/akun/tambah', [AdminController::class, 'storeAdmin'])->name('admin.account.store');
Route::delete('/admin/akunadmin/delete/{id}', [AdminController::class, 'destroyAdmins'])->name('admin.admins.destroy')->middleware('auth');
