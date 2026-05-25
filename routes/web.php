<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuyerController;
use App\Http\Controllers\FarmerController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('home');

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.store');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('session.auth')->group(function () {
    Route::prefix('buyer')->name('buyer.')->middleware('role:buyer')->group(function () {
        Route::get('/marketplace', [BuyerController::class, 'marketplace'])->name('marketplace');
        Route::post('/orders/{product}', [BuyerController::class, 'order'])->name('orders.store');
    });

    Route::prefix('farmer')->name('farmer.')->middleware('role:farmer')->group(function () {
        Route::get('/marketplace', [FarmerController::class, 'marketplace'])->name('marketplace');
        Route::get('/dashboard', [FarmerController::class, 'dashboard'])->name('dashboard');
        Route::get('/products/create', [FarmerController::class, 'createProduct'])->name('products.create');
        Route::post('/products', [FarmerController::class, 'storeProduct'])->name('products.store');
        Route::post('/orders/{product}', [FarmerController::class, 'order'])->name('orders.store');
        Route::get('/advisor', [FarmerController::class, 'chat'])->name('advisor');
        Route::post('/advisor', [FarmerController::class, 'askAdvisor'])->name('advisor.ask');
    });
});
