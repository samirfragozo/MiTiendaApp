<?php

namespace App\Providers;

use Darryldecode\Cart\Cart;
use Illuminate\Support\ServiceProvider;

class CartProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('stores', function($app)
        {
            $storage = $app['session'];
            $events = $app['events'];
            $instanceName = 'stores_cart';
            $session_key = 'stores';
            return new Cart(
                $storage,
                $events,
                $instanceName,
                $session_key,
                config('shopping_cart')
            );
        });

        $this->app->singleton('providers', function($app)
        {
            $storage = $app['session'];
            $events = $app['events'];
            $instanceName = 'providers_cart';
            $session_key = 'providers';
            return new Cart(
                $storage,
                $events,
                $instanceName,
                $session_key,
                config('shopping_cart')
            );
        });
    }
}
