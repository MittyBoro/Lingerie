<?php

namespace App\Services\Cart\Storage;

use Carbon\Carbon;
use Cookie;
use Cache;
use Darryldecode\Cart\CartCollection;

class CacheStorage
{
    private $data = [];
    private $cart_id;
    private $storage_days = 30;

    public function __construct()
    {
        $this->cart_id = Cookie::get('cart');
        if ($this->cart_id) {
            $this->data = Cache::get('cart_' . $this->cart_id, []);
        } else {
            $this->cart_id = uniqid();
        }
    }

    public function has($key)
    {
        return isset($this->data[$key]);
    }

    public function get($key)
    {
        return new CartCollection($this->data[$key] ?? []);
    }

    public function put($key, $value)
    {
        $this->data[$key] = $value;
        Cache::put('cart_' . $this->cart_id, $this->data, Carbon::now()->addDays($this->storage_days));

        if (!Cookie::hasQueued('cart')) {
            Cookie::queue(
                Cookie::make('cart', $this->cart_id, 60 * 24 * $this->storage_days)
            );
        }
    }
}
