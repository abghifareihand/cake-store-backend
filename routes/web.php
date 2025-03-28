<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('pages.auth.login');
});


Route::middleware(['auth'])->group(function () {
    Route::get('home', [DashboardController::class, 'index'])->name('home');
    Route::resource('users', UserController::class);
    Route::resource('products', ProductController::class);
});
