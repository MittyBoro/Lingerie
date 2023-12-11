<?php

namespace App\Services\Cart\Traits;

use App\Models\Product;
use App\Models\Prop;
use Darryldecode\Cart\CartCondition;

trait FinalTrait
{

    public function setShipping()
    {
        $cy = config('app.currency');
        $freeShippingProp = Prop::findByKey('free_shipping_'. $cy);
        $shippingProp = Prop::findByKey('shipping_'. $cy);
        $subTotal = $this->cart->getSubTotal();
        $shipping = intval($freeShippingProp && $subTotal > $freeShippingProp ? 0 : $shippingProp);


        if ($shipping) {
            $shippingString = ($shipping < 0 ? "-" : "+") . abs($shipping);

            $this->cart->condition(new CartCondition([
                'name' => 'shipping',
                'type' => __('front.shipping'),
                'target' => 'total',
                'value' => $shippingString,
            ]));
        }
        else {
            $this->cart->removeCartCondition('shipping');
        }
    }

    /**
     * Изменить цены перед checkout и перед оплатой
     */
    private function recalculateCart()
    {
        if ($this->getRaw()->isEmpty()) {
            return;
        }

        $cartIds = $this->getRaw()->map(function ($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->associatedModel['id'],
            ];
        })->values();

        $prodIds = $cartIds->pluck('product_id')->unique();
        $prices = Product::pricesById($prodIds, locale());

        $cartIds->each(function ($row) use ($prices) {
            $prod = $prices->find($row['product_id']);

            if ($prod) {
                $this->cart->update($row['id'],[
                            'price' => $prod->price,
                            'name' => $prod->title,
                        ]);
            }
            else {
                $this->destroy($row['id']);
            }
        });
    }

}
