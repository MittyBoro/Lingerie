<?php

namespace App\Services\Cart\Traits;

use Illuminate\Support\Facades\Cookie;

trait HelperTrait
{

    private function guestId()
    {
        $key = 'cart_id_' . $this->lang;

        $cart_id = Cookie::get($key);

        $storage_days = 30;

        if (!$cart_id) {
            $cart_id = 'guest_'.uniqid();
            Cookie::queue(
                Cookie::make($key, $cart_id, 60 * 24 * $storage_days)
            );
        }

        return $cart_id;
    }

    private function readableItem($item)
    {
        $model = $item->associatedModel;

        $options = collect($item->attributes->options)->map(function($opt) {
            $type = __('front.'.$opt['type']);
            $value = ($opt['type'] == 'color') ? __('front.colors.'.$opt['value']) : $opt['value'];

            $opt['string'] = $type . ': ' . $value;

            return $opt;
        });

        return [
            'id' => $item->id,
            'product_id' => $model['id'],
            'url' => route('front.product', $model['slug']),
            'preview' => $model['preview'],
            'name' => $item->name,
            'options' => $options,
            'quantity' => $item->quantity,
            'price' => $item->price,
        ];
    }

}
