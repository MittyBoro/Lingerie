<?php

namespace App\Services\Cart;

use App\Models\Product;
use App\Models\Prop;

use Darryldecode\Cart\CartCondition;
use Darryldecode\Cart\CartServiceProvider;

use Cart;
use Illuminate\Database\Eloquent\Model;

class CartService
{

    public function get()
    {
        $cart = Cart::getContent()->sort()->values();

        return $cart;
    }
    public function getReadable()
    {
        return $this->get()->map(function($item,) {
            $model = (array)$item->associatedModel;

            $optionsString = collect($item->attributes->options)->map(function($opt) {
                $type = __('front.'.$opt['type']);
                $value = ($opt['type'] == 'color') ? __('front.colors.'.$opt['value']) : $opt['value'];

                return $type . ': ' . $value;
            })->implode(', ');;

            return [
                'id' => $item->id,
                'product_id' => $model['id'],
                'url' => route('front.product', $model['slug']),
                'preview' => $model['preview'],
                'name' => $item->name,
                'options' => $item->attributes->options,
                'options_string' => $optionsString,
                'quantity' => $item->quantity,
                'price' => $item->price,
            ];
        });
    }

    public function getMini()
    {
        return $this->get()->map(function($item,) {
            return [
                'id' => $item->id,
                'quantity' => $item->quantity,
            ];
        });
    }

    public function store($data, Model $product)
    {
        Cart::add([
            'id' => $data['id'],
            'name' => $data['name'],
            'price' => $data['price'],
            'quantity' => $data['quantity'] ?? 1,
            'attributes' => $data['attributes'] ?? [],
            'associatedModel' => $product->toArray()
        ]);

        return Cart::getContent()->count();
    }

    public function update($cart_id, $quantity)
    {
        Cart::update($cart_id, [
            'quantity' => [
                'relative' => false,
                'value' => $quantity,
            ]
        ]);
    }

    public function destroy($cart_id)
    {
        return Cart::remove($cart_id);
    }

    public function clear()
    {
        return Cart::clear();
    }

    public function count()
    {
        return Cart::getContent()->count();
    }

    public function total()
    {
        $this->setShipping();

        return Cart::getTotal();
    }


    public function setShipping()
    {
        $freeShippingProp = Prop::findByKey('free_shipping');
        $shippingProp = Prop::findByKey('shipping');
        $subTotal = Cart::getSubTotal();
        $shipping = $freeShippingProp && $subTotal > $freeShippingProp ? 0 : $shippingProp;

        Cart::condition(new CartCondition([
            'name' => 'shipping',
            'type' => 'shipping',
            'target' => 'total',
            'value' => $shipping,
            // 'attributes' => [
            //     'description' => 'Value added tax',
            //     'more_data' => 'more data here'
            // ]
        ]));
    }

}
