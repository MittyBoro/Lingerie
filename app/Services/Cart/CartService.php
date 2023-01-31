<?php

namespace App\Services\Cart;

use App\Models\Prop;

use Darryldecode\Cart\CartCondition;

use Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

class CartService
{

    private $cart;
    private $rawCart;

    public function __construct()
    {
        $this->cart = Cart::session($this->guestId());
    }

    public function get()
    {
        $cart = $this->getRaw()->map(fn($item) => $this->readableItem($item));

        return $cart;
    }

    public function getMini()
    {
        return $this->getRaw()->map(function($item,) {
            return [
                'id' => $item->id,
                'quantity' => $item->quantity,
            ];
        });
    }

    public function store($data, Model $product)
    {
        $this->cart->add([
            'id' => $data['id'],
            'name' => $data['name'],
            'price' => $data['price'],
            'quantity' => $data['quantity'] ?? 1,
            'attributes' => $data['attributes'] ?? [],
            'associatedModel' => $product->toArray()
        ]);

        return $this->count();
    }

    public function update($cart_id, $quantity)
    {
        $this->cart->update($cart_id, [
            'quantity' => [
                'relative' => false,
                'value' => $quantity,
            ]
        ]);
    }

    public function destroy($cart_id)
    {
        return $this->cart->remove($cart_id);
    }

    public function clear()
    {
        return $this->cart->clear();
    }

    public function count()
    {
        return $this->getRaw()->count();
    }

    public function final()
    {
        $this->setShipping();

        $cart = $this->get();
        $conditions = $this->cart->getConditions()->values()
                           ->map(function ($item){
                               return [
                                    'name' => $item->getName(),
                                    'type' => $item->getType(),
                                    'value' => $item->getValue(),
                               ];
                           });
        $subtotal = $this->cart->getSubTotal();
        $total = $this->cart->getTotal();

        return [
            'data' => $cart,
            'conditions' => $conditions,
            'subtotal' => $subtotal,
            'total' => $total,
        ];
    }


    public function setShipping()
    {
        $freeShippingProp = Prop::findByKey('free_shipping');
        $shippingProp = Prop::findByKey('shipping') ?: 100;
        $subTotal = $this->cart->getSubTotal();
        $shipping = $freeShippingProp && $subTotal > $freeShippingProp ? 0 : $shippingProp;

        $shippingString = ($shipping < 0 ? "-" : "+") . abs($shipping);

        $this->cart->condition(new CartCondition([
            'name' => 'shipping',
            'type' => __('front.shipping'),
            'target' => 'total',
            'value' => $shippingString,
        ]));
    }

    public function getRaw()
    {
        if (!$this->rawCart) {
            $this->rawCart = $this->cart->getContent()->sort()->values();
        }

        return $this->rawCart;
    }

    private function readableItem($item)
    {
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
    }


    private function guestId()
    {
        $lang = App::getLocale();
        $key = 'cart_id_' . $lang;

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

}
