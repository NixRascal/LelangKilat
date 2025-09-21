<?php

use App\Http\Controllers\Api\V1\AuditLogController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\AuctionController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\HealthController;
use App\Http\Controllers\Api\V1\ReportController;
use App\Http\Controllers\Api\V1\SettingController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\WalletController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::post('auth/register', [AuthController::class, 'register']);
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('auth/reset-password', [AuthController::class, 'resetPassword']);

    Route::get('health/live', [HealthController::class, 'live']);

    Route::middleware(['auth:sanctum', 'throttle:api'])->group(function () {
        Route::post('auth/logout', [AuthController::class, 'logout']);
        Route::post('auth/refresh', [AuthController::class, 'refresh']);
        Route::post('auth/change-password', [AuthController::class, 'changePassword']);

        Route::get('health/ready', [HealthController::class, 'ready']);

        Route::get('dashboard', [DashboardController::class, 'index']);

        Route::get('settings/profile', [SettingController::class, 'profile']);
        Route::patch('settings/preferences', [SettingController::class, 'updatePreferences']);

        Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);
        Route::apiResource('categories', CategoryController::class)
            ->only(['store', 'update', 'destroy'])
            ->middleware('role:admin,staff');

        Route::apiResource('auctions', AuctionController::class);
        Route::get('auctions/{auction}/bids', [AuctionController::class, 'bids']);
        Route::post('auctions/{auction}/bids', [AuctionController::class, 'placeBid']);

        Route::get('wallet/transactions', [WalletController::class, 'index']);
        Route::post('wallet/top-up', [WalletController::class, 'topUp']);

        Route::get('reports/auctions/export', [ReportController::class, 'exportAuctions'])->middleware('role:admin,staff');

        Route::get('audit-logs', [AuditLogController::class, 'index'])->middleware('role:admin');

        Route::apiResource('users', UserController::class)->middleware('role:admin');
    });
});
