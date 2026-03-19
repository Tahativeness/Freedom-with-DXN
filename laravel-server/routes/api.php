<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SiteSettingsController;
use Illuminate\Support\Facades\Route;

// ─── Auth ────────────────────────────────────────────────────────────────────
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);
    Route::post('/contact',  [AuthController::class, 'contact']);

    Route::middleware('jwt')->group(function () {
        Route::get('/me',              [AuthController::class, 'me']);
        Route::put('/profile',         [AuthController::class, 'updateProfile']);
        Route::put('/change-password', [AuthController::class, 'changePassword']);

        Route::middleware('admin')->group(function () {
            Route::post('/create-admin', [AuthController::class, 'createAdmin']);
            Route::get('/users',         [AuthController::class, 'getUsers']);
        });
    });
});

// ─── Products ────────────────────────────────────────────────────────────────
Route::prefix('products')->group(function () {
    Route::get('/',    [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show']);

    Route::middleware('jwt')->group(function () {
        Route::post('/{id}/review', [ProductController::class, 'addReview']);

        Route::middleware('admin')->group(function () {
            Route::get('/scrape',   [ProductController::class, 'scrape']);
            Route::post('/',        [ProductController::class, 'store']);
            Route::put('/{id}',     [ProductController::class, 'update']);
            Route::delete('/{id}',  [ProductController::class, 'destroy']);
        });
    });
});

// ─── Orders ──────────────────────────────────────────────────────────────────
Route::prefix('orders')->middleware('jwt')->group(function () {
    Route::post('/',               [OrderController::class, 'store']);
    Route::get('/my',              [OrderController::class, 'myOrders']);

    Route::middleware('admin')->group(function () {
        Route::get('/',                        [OrderController::class, 'index']);
        Route::put('/{id}/status',             [OrderController::class, 'updateStatus']);
    });
});

// ─── Distributors ────────────────────────────────────────────────────────────
Route::prefix('distributors')->middleware('jwt')->group(function () {
    Route::get('/dashboard',     [DistributorController::class, 'dashboard']);
    Route::get('/downlines',     [DistributorController::class, 'downlines']);
    Route::get('/referral-link', [DistributorController::class, 'referralInfo']);

    Route::middleware('admin')->group(function () {
        Route::get('/all',          [DistributorController::class, 'all']);
        Route::put('/{id}/role',    [DistributorController::class, 'updateRole']);
    });
});

// ─── Blog ────────────────────────────────────────────────────────────────────
Route::prefix('blog')->group(function () {
    Route::get('/',       [BlogController::class, 'index']);
    Route::get('/{slug}', [BlogController::class, 'show']);

    Route::middleware(['jwt', 'admin'])->group(function () {
        Route::post('/',      [BlogController::class, 'store']);
        Route::put('/{id}',   [BlogController::class, 'update']);
        Route::delete('/{id}',[BlogController::class, 'destroy']);
    });
});

// ─── Site Settings ───────────────────────────────────────────────────────────
Route::prefix('site-settings')->group(function () {
    Route::get('/', [SiteSettingsController::class, 'show']);
    Route::middleware(['jwt', 'admin'])->put('/', [SiteSettingsController::class, 'update']);
});
