<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ShopController;
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

// Rute publice pentru Shop
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('shop.show');

// Checkout routes (fără auth - oricine poate comanda)
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');

// Orders history - doar pentru utilizatori autentificați
Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('/orders', 'orders')->name('orders');
    Route::view('/cart', 'cart')->name('cart');
});

// Rute admin (protejate cu middleware custom)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
    Route::delete('products/{product}/images', [ProductController::class, 'deleteImage'])
        ->name('products.delete-image');
    Route::view('/orders', 'admin.orders')->name('orders');

    // User management routes
    Route::resource('users', UserController::class);
});

require __DIR__.'/auth.php';