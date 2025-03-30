<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CallbackController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;


// ✅ ROUTE YANG MEMBUTUHKAN AUTH (harus pakai token)
Route::middleware('auth:sanctum')->group(function () {
    // User Routes
    Route::get('/user', [AuthController::class, 'getUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Cart Routes
    Route::get('/cart', [CartController::class, 'getCart']);
    Route::post('/cart', [CartController::class, 'addToCart']);
    Route::put('/cart/{id}', [CartController::class, 'updateCart']);
    Route::delete('/cart/{id}', [CartController::class, 'removeFromCart']);
    Route::delete('/cart', [CartController::class, 'clearCart']);

    // Order Routes
    Route::post('/order', [OrderController::class, 'order']);
    Route::get('/order', [OrderController::class, 'getOrder']);
    Route::get('/order-status/{orderId}', [OrderController::class, 'checkOrderStatus']);
});

// ✅ ROUTE UNTUK AUTHENTICATION
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// ✅ ROUTE UNTUK GET PRODUCT
Route::get('/product', [ProductController::class, 'getProduct']);


// ✅ ROUTE UNTUK MIDTRANS CALLBACK
Route::post('/midtrans/callback', [CallbackController::class, 'callback']);
