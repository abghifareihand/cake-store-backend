<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// ✅ ROUTE UNTUK AUTHENTICATION
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ✅ ROUTE UNTUK GET PRODUCT
Route::get('/product', [ProductController::class, 'getProduct']);

// ✅ ROUTE YANG MEMBUTUHKAN AUTH (Harus pakai token)
Route::middleware('auth:sanctum')->group(function () {
    // User Routes
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Cart Routes
    Route::get('/cart', [CartController::class, 'getCart']);
    Route::post('/cart', [CartController::class, 'addToCart']);
    Route::put('/cart/{id}', [CartController::class, 'updateCart']);
    Route::delete('/cart/{id}', [CartController::class, 'removeFromCart']);
});
