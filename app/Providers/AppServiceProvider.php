<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use App\Models\Wishlist;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Migrează wishlist-ul din sesiune în baza de date când userul se loghează
        Event::listen(Login::class, function ($event) {
            $sessionWishlist = session()->get('wishlist', []);

            if (!empty($sessionWishlist) && $event->user) {
                foreach ($sessionWishlist as $productId) {
                    Wishlist::firstOrCreate([
                        'user_id' => $event->user->id,
                        'product_id' => $productId,
                    ]);
                }

                // Șterge wishlist-ul din sesiune după migrare
                session()->forget('wishlist');
            }
        });
    }
}
