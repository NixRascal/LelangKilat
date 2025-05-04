<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('register', [AuthController::class,'showoRegisterForm'])->name('register.form');
Route::post('register', [AuthController::class,'register'])->name('register');

Route::get('login', [AuthController::class,'showLoginForm'])->name('login.form');
Route::post('login', [AuthController::class,'login'])->name('login');

Route::post('logout', [AuthController::class,'logout'])->name('logout');