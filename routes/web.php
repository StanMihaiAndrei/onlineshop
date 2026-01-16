<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ColorController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('home');

// Despre noi
Route::get('/despre-noi', [AboutController::class, 'index'])->name('about');

// Contact
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/hello', function () {
    return view('hello');
})->name('hello');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/products/{product}/reviews', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/wishlist', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');
});

// Rute publice pentru Shop
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/{categorySlug}', [ShopController::class, 'category'])->name('shop.category');
Route::get('/shop/{categorySlug}/{productSlug}', [ShopController::class, 'showByCategory'])->name('shop.product');

// Checkout routes (fără auth - oricine poate comanda)
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
Route::get('/checkout/success/{order}', [CheckoutController::class, 'success'])->name('checkout.success');
Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('checkout.applyCoupon');
Route::delete('/checkout/remove-coupon', [CheckoutController::class, 'removeCoupon'])->name('checkout.removeCoupon');

Route::get('/checkout/counties', [CheckoutController::class, 'getCounties'])->name('checkout.counties');
Route::get('/checkout/cities', [CheckoutController::class, 'getCities'])->name('checkout.cities');
Route::get('/checkout/lockers', [CheckoutController::class, 'getLockers'])->name('checkout.lockers');
Route::post('/checkout/calculate-shipping', [CheckoutController::class, 'calculateShipping'])->name('checkout.calculateShipping');

// Stripe routes
Route::get('/stripe/success/{order}', [CheckoutController::class, 'stripeSuccess'])->name('stripe.success');
Route::get('/stripe/cancel/{order}', [CheckoutController::class, 'stripeCancel'])->name('stripe.cancel');
Route::post('/stripe/webhook', [CheckoutController::class, 'webhook'])->name('stripe.webhook');

// Orders history - doar pentru utilizatori autentificați
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::view('/cart', 'cart')->name('cart');
});

// Rute admin (protejate cu middleware custom)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
    Route::delete('products/{product}/images', [ProductController::class, 'deleteImage'])
        ->name('products.delete-image');

    // Admin Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::patch('/orders/{order}/payment', [AdminOrderController::class, 'updatePaymentStatus'])->name('orders.updatePayment');

     Route::prefix('orders')->name('orders.')->group(function () {
        Route::post('/{order}/awb/home', [AdminOrderController::class, 'createHomeAwb'])->name('createHomeAwb');
        Route::post('/{order}/awb/locker', [AdminOrderController::class, 'createLockerAwb'])->name('createLockerAwb');
        Route::post('/{order}/awb/sync', [AdminOrderController::class, 'syncAwbStatus'])->name('syncAwbStatus');
        Route::get('/{order}/awb/download', [AdminOrderController::class, 'downloadAwbPdf'])->name('downloadAwbPdf');
    });

    // User management routes
    Route::resource('users', UserController::class);
    Route::post('users/{user}/toggle-email-verification', [UserController::class, 'toggleEmailVerification'])
        ->name('users.toggle-email-verification');

    // Nomenclatoare
    Route::resource('colors', ColorController::class);
    Route::resource('categories', CategoryController::class);

    Route::resource('coupons', CouponController::class);
});

Route::get('/test-sameday', function() {
    $service = new \App\Services\SamedayService();
    
    // Clear cache pentru testing
    $service->clearCache();
    
    // Test authentication
    $token = $service->authenticate();
    
    // Get EVERYTHING from DEMO environment
    $pickupPoints = $service->getPickupPoints();
    $services = $service->getServices();
    $counties = $service->getCounties();
    
    // Get lockers for Bucuresti (county 1)
    $lockers = $service->getLockers(0, 1, null);
    
    return response()->json([
        'token' => $token ? 'OK' : 'FAILED',
        'pickup_points' => $pickupPoints,
        'services' => $services,
        'counties' => $counties,
        'lockers_sample' => array_slice($lockers, 0, 5), // First 5 lockers
        'message' => 'Check all IDs - these are DEMO IDs, not production!'
    ]);
});

require __DIR__.'/auth.php';