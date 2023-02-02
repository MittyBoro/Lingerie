<?php

namespace App\Services\Cart\Traits;

trait HelperTrait
{
    private function readableItem($item)
    {
        $model = $item->associatedModel;

        $options = collect($item->attributes->options)->map(function($opt) {
            $type = trans('front.'.$opt['type']);
            $value = ($opt['type'] == 'color') ? trans('front.colors.'.$opt['value']) : $opt['value'];

            $opt['string'] = $type . ': ' . $value;

            return $opt;
        });

        return [
            'id' => $item->id,
            'product_id' => $model['id'],
            'url' => route('front.products', $model['slug']),
            'preview' => $model['preview'],
            'name' => $item->name,
            'options' => $options,
            'options_string' => $options->pluck('string')->implode(', '),
            'quantity' => $item->quantity,
            'price' => $item->price,
        ];
    }

}
