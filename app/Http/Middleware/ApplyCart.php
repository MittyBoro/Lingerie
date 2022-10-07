<?php

namespace App\Http\Middleware;

use App\Services\Cart\CartService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class ApplyCart
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if ($request->user())
            $sessionId = $request->user()->id;
        else
            $sessionId = $this->guestId();

        \Cart::session($sessionId);

        $request->cart = new CartService(); // закинуть бы в app, но уже лень

        return $next($request);
    }

    private function guestId()
    {
        $cart_id = Cookie::get('guest_cart_id');

        $storage_days = 30;

        if (!$cart_id) {
            $cart_id = 'guest_'.uniqid();
            Cookie::queue(
                Cookie::make('guest_cart_id', $cart_id, 60 * 24 * $storage_days)
            );
        }

        return $cart_id;
    }
}
