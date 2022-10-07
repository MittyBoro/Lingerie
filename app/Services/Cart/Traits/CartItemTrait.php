<?php

namespace App\Services\Cart\Traits;

use App\Models\Product\Product;

trait CartItemTrait
{

    private function getSupplementedItem($item)
    {
        if ($item->conditions) {
            $discounPrice = $item->getPriceWithConditions();

            if ( $discounPrice ) {
                $diff = $item->price - $discounPrice;
                $percent = $diff / $discounPrice * 100;

                $item->put('discount_price', $discounPrice);

                if ($percent)
                    $item->put('percent', round($percent, 1) * -1);
            }
        }
        return $item;
    }

    private function getCreatableItem($item, $allowAddBonuses)
    {
        return [
            'product_id' => $item->attributes->product_id,
            'name' => $item->name,
            'price' => $item->price,
            'discount_price' => $item->discount_price ?: $item->price,
            'bonuses' => $allowAddBonuses ? $item->attributes->bonuses : 0,
            'quantity' => $item->quantity,
            'variations' => $item->attributes->variations,
        ];
    }

    private function arrayForItem(Product $product, $variationIds): array
    {
        $variations = $product->variations->whereIn('id', $variationIds);

        if (!$product->is_available || count($variationIds) != $variations->count()) {
            throw new \Exception('Некорректный товар');
        }

        $cartItem = [
            'price' => $variations->sum('price'),
            'attributes' => [
                'product_id' => $product->id,
                'slug' => $product->slug,
                'preview' => $product->preview,
                'bonuses' => $variations->sum('bonuses'),
                'variations' => $variations->map(fn ($item) => $item->for_cart)->toArray(),
            ],
        ];

        return $cartItem;
    }

}
