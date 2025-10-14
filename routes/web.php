<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/hello', function () {
    return view('hello');
})->name('hello');

// Rute publice
Route::view('/shop', 'shop')->name('shop');

// Rute pentru clienți autentificați
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/orders', 'orders')->name('orders');
    Route::view('/cart', 'cart')->name('cart');
});

// Rute admin (protejate cu middleware custom)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::view('/admin/products', 'admin.products')->name('admin.products');
    Route::view('/admin/orders', 'admin.orders')->name('admin.orders');
});

require __DIR__.'/auth.php';