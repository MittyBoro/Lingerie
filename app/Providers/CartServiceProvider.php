<?php

namespace App\Providers;

use App\Services\Cart\CartService;
use Darryldecode\Cart\Cart;

use Illuminate\Contracts\Support\DeferrableProvider;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
		$this->app->singleton('cart', function($app)
		{
            $storageClass = config('shopping_cart.storage');
            $eventsClass = config('shopping_cart.events');

            $storage = $storageClass ? new $storageClass() : $app['session'];
            $events = $eventsClass ? new $eventsClass() : $app['events'];
			$instanceName = 'cart';

			$session_key = $this->cartId();

			$cart = new Cart(
				$storage,
				$events,
				$instanceName,
				$session_key,
				config('shopping_cart')
			);

            return new CartService($cart, $session_key);
		});
    }

    public function provides()
    {
        return ['cart'];
    }

    private function cartId()
    {
        $key = 'cart_id_' . App::getLocale();

        $cartId = Cookie::get($key);

        if (!$cartId) {
            $cartId = 'guest_'.uniqid();
            $storage_days = 30;
            Cookie::queue(
                Cookie::make($key, $cartId, 60 * 24 * $storage_days)
            );
        }

        return $cartId;
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
