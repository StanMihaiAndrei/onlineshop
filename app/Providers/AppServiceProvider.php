<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Mailer\Bridge\Brevo\Transport\BrevoTransportFactory;
use Symfony\Component\Mailer\Transport\Dsn;

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
        // Înregistrează transportul Brevo
        Mail::extend('brevo', function (array $config) {
            return (new BrevoTransportFactory)->create(
                new Dsn(
                    'brevo+api',
                    'default',
                    $config['key']
                )
            );
        });

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
