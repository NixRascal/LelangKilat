<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\AuctionController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 1. Redirect root URL (/) ke halaman login
Route::redirect('/', '/masuk');

// 2. Authentication Routes
// — Form login (hanya guest)
Route::get('/masuk', [AuthController::class, 'showLoginForm'])
    ->name('login.form');
// — Proses login
Route::post('/masuk', [AuthController::class, 'login'])
    ->name('login');
// — Logout (hanya authenticated)
Route::post('/keluar', [AuthController::class, 'logout'])
     ->name('logout')
     ->middleware('auth');

// — Form registrasi (hanya guest)
Route::get('/daftar', [AuthController::class, 'showRegisterForm'])
    ->name('register.form');
// — Proses registrasi
Route::post('/daftar', [AuthController::class, 'register'])
    ->name('register');


// 3. Home (hanya authenticated)
Route::get('/home', [HomeController::class, 'index'])
    ->name('home')
    ->middleware('auth');


// 4. Wallet (hanya authenticated)
Route::get('/wallet', [WalletController::class, 'index'])
    ->name('wallet.index')
    ->middleware('auth');


// 5. Auction Routes
// — Daftar semua lelang (publik)
Route::get('/auctions', [AuctionController::class, 'index'])
    ->name('auctions.index');
// — Form buat lelang (authenticated)
Route::get('/auctions/create', [AuctionController::class, 'create'])
    ->name('auctions.create')
    ->middleware('auth');
// — Simpan lelang baru
Route::post('/auctions', [AuctionController::class, 'store'])
    ->name('auctions.store')
    ->middleware('auth');
// — Lelang yang diikuti user
Route::get('/auctions/participated', [AuctionController::class, 'participated'])
    ->name('auctions.participated')
    ->middleware('auth');
// — Lelang milik user
Route::get('/auctions/mine', [AuctionController::class, 'mine'])
    ->name('auctions.mine')
    ->middleware('auth');
// — Filter lelang berdasarkan kategori
Route::get('/auctions/category/{category}', [AuctionController::class, 'index'])
    ->name('auctions.category');
// — Detail satu lelang
Route::get('/auctions/{auction}', [AuctionController::class, 'show'])
    ->name('auctions.show');
    
// 6. Admin Routes (hanya authenticated)
// — Role checking (opsional)
// — Dashboard
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->name('admin.dashboard')
    ->middleware('auth');
// — Manajemen pengguna
Route::get('/admin/pengguna', [AdminController::class, 'user'])
    ->name('admin.user')
    ->middleware('auth');
// — List semua lelang (admin)
Route::get('/admin/lelang', [AdminController::class, 'auction'])
    ->name('admin.auction')
    ->middleware('auth');
// — Edit lelang
Route::get('/admin/lelang/edit/{id}', [AdminController::class, 'editAuction'])
    ->name('admin.auction.edit')
    ->middleware('auth');
// — Update lelang
Route::put('/admin/lelang/update/{id}', [AdminController::class, 'updateAuction'])
    ->name('admin.auction.update')
    ->middleware('auth');
// — Hapus lelang
Route::delete('/admin/lelang/delete/{id}', [AdminController::class, 'destoryAuction'])
    ->name('admin.auction.destroy')
    ->middleware('auth');
