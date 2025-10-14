<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');


Route::get('/hello', function () {
    return view('hello');
});

Route::view('/shop', 'shop')->name('shop');
Route::view('/orders', 'orders')->middleware(['auth', 'verified'])->name('orders');

// Rute admin (protejate cu middleware custom)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::view('/admin/products', 'admin.products')->name('admin.products');
    Route::view('/admin/orders', 'admin.orders')->name('admin.orders');
});

require __DIR__.'/auth.php';
