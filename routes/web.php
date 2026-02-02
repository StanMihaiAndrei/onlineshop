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

/*
|--------------------------------------------------------------------------
| Public Routes (Guest)
|--------------------------------------------------------------------------
*/

// Homepage
Route::get('/', [WelcomeController::class, 'index'])->name('home');

// Informational Pages
Route::get('/despre-noi', [AboutController::class, 'index'])->name('about');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');

// Shop (Public)
Route::prefix('shop')->name('shop')->group(function () {
    Route::get('/', [ShopController::class, 'index']);
    Route::get('/{categorySlug}', [ShopController::class, 'category'])->name('.category');
    Route::get('/{categorySlug}/{productSlug}', [ShopController::class, 'showByCategory'])->name('.product');
});

// Checkout (Public - oricine poate comanda)
Route::prefix('checkout')->name('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index']);
    Route::post('/', [CheckoutController::class, 'store'])->name('.store');
    Route::get('/success/{order}', [CheckoutController::class, 'success'])->name('.success');

    // Coupon Management
    Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('.applyCoupon');
    Route::delete('/remove-coupon', [CheckoutController::class, 'removeCoupon'])->name('.removeCoupon');

    // Shipping Data (AJAX)
    Route::get('/counties', [CheckoutController::class, 'getCounties'])->name('.counties');
    Route::get('/cities', [CheckoutController::class, 'getCities'])->name('.cities');
    Route::get('/lockers', [CheckoutController::class, 'getLockers'])->name('.lockers');
    Route::post('/calculate-shipping', [CheckoutController::class, 'calculateShipping'])->name('.calculateShipping');
});

// Stripe Payment Routes
Route::prefix('stripe')->name('stripe.')->group(function () {
    Route::get('/success/{order}', [CheckoutController::class, 'stripeSuccess'])->name('success');
    Route::get('/cancel/{order}', [CheckoutController::class, 'stripeCancel'])->name('cancel');
    Route::post('/webhook', [CheckoutController::class, 'webhook'])->name('webhook');
});

// Legal pages
Route::view('/termeni-si-conditii', 'legal.terms')->name('legal.terms');
Route::view('/politica-de-confidentialitate', 'legal.privacy')->name('legal.privacy');
Route::view('/politica-de-returnare', 'legal.delivery')->name('legal.delivery');
Route::view('/politica-de-cookies', 'legal.cookies')->name('legal.cookies');

/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard & Profile
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::view('profile', 'profile')->name('profile');

    // Cart
    Route::view('/cart', 'cart')->name('cart');

    // Wishlist
    Route::get('/wishlist', [App\Http\Controllers\WishlistController::class, 'index'])->name('wishlist.index');

    // Reviews
    Route::post('/products/{product}/reviews', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [App\Http\Controllers\ReviewController::class, 'destroy'])->name('reviews.destroy');

    // Orders History
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{order}', [OrderController::class, 'show'])->name('show');
        Route::get('/{order}/invoice/download', [OrderController::class, 'downloadInvoice'])->name('downloadInvoice');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {

    // Products Management
    Route::resource('products', ProductController::class);
    Route::delete('products/{product}/images', [ProductController::class, 'deleteImage'])
        ->name('products.delete-image');

    // Orders Management
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');
        Route::patch('/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('updateStatus');
        Route::patch('/{order}/payment', [AdminOrderController::class, 'updatePaymentStatus'])->name('updatePayment');

        // AWB Management (Sameday)
        Route::post('/{order}/awb/home', [AdminOrderController::class, 'createHomeAwb'])->name('createHomeAwb');
        Route::post('/{order}/awb/locker', [AdminOrderController::class, 'createLockerAwb'])->name('createLockerAwb');
        Route::post('/{order}/awb/sync', [AdminOrderController::class, 'syncAwbStatus'])->name('syncAwbStatus');
        Route::get('/{order}/awb/download', [AdminOrderController::class, 'downloadAwbPdf'])->name('downloadAwbPdf');
        Route::get('/{order}/invoice/download', [AdminOrderController::class, 'downloadInvoice'])->name('downloadInvoice');
    });

    // Users Management
    Route::resource('users', UserController::class);
    Route::post('users/{user}/toggle-email-verification', [UserController::class, 'toggleEmailVerification'])
        ->name('users.toggle-email-verification');

    // Nomenclatoare (Settings)
    Route::resource('categories', CategoryController::class);
    Route::resource('colors', ColorController::class);
    Route::resource('coupons', CouponController::class);
});

/*
|--------------------------------------------------------------------------
| Development/Testing Routes
|--------------------------------------------------------------------------
*/

// Test route - remove in production
Route::get('/test-sameday', function () {
    $service = new \App\Services\SamedayService();

    $service->clearCache();
    $token = $service->authenticate();

    $pickupPoints = $service->getPickupPoints();
    $services = $service->getServices();
    $counties = $service->getCounties();
    $lockers = $service->getLockers(0, 1, null);

    return response()->json([
        'token' => $token ? 'OK' : 'FAILED',
        'pickup_points' => $pickupPoints,
        'services' => $services,
        'counties' => $counties,
        'lockers_sample' => array_slice($lockers, 0, 5),
        'message' => 'Check all IDs - these are DEMO IDs, not production!'
    ]);
});

// Hello test route - remove in production
Route::get('/hello', function () {
    return view('hello');
})->name('hello');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';
