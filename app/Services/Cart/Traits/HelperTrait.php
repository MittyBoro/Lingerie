<?php

namespace App\Services\Cart\Traits;

use Illuminate\Support\Facades\Cookie;

trait HelperTrait
{

    public function cartId()
    {
        $key = 'cart_id_' . $this->lang;

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

    private function readableItem($item)
    {
        $model = $item->associatedModel;

        $options = collect($item->attributes->options)->map(function($opt) {
            $type = __('front.'.$opt['type']);
            $value = ($opt['type'] == 'color') ? __('front.colors.'.$opt['value']) : $opt['value'];

            $opt['string'] = $type . ': ' . $value;

            return $opt;
        });

        return [
            'id' => $item->id,
            'product_id' => $model['id'],
            'url' => route('front.product', $model['slug']),
            'preview' => $model['preview'],
            'name' => $item->name,
            'options' => $options,
            'options_string' => $options->pluck('string')->implode(', '),
            'quantity' => $item->quantity,
            'price' => $item->price,
        ];
    }

}
