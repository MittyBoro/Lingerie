<?php

namespace App\Services\Cart;

use App\Services\Cart\Traits\FinalTrait;
use App\Services\Cart\Traits\HelperTrait;

use Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class CartService
{
    use HelperTrait;
    use FinalTrait;

    private $lang;
    private $cart;

    public function __construct()
    {
        $this->lang = App::getLocale();
        $this->cart = Cart::session($this->guestId());
    }

    public function get()
    {
        $cart = $this->getRaw()->map(fn($item) => $this->readableItem($item));

        return $cart;
    }

    public function getRaw()
    {
        return $this->cart->getContent()->sort()->values();
    }

    public function condtions()
    {
        return $this->cart->getConditions()->values();
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

    public function total()
    {
        return $this->cart->getTotal();
    }

    public function final()
    {
        $this->recalculateCart();
        $this->setShipping();

        $conditions = $this->condtions()
                           ->map(function ($item){
                               return [
                                    'name' => $item->getName(),
                                    'type' => $item->getType(),
                                    'value' => $item->getValue(),
                               ];
                           });
        $subtotal = $this->cart->getSubTotal();
        $total = $this->total();
        $cart = $this->get();

        return [
            'data' => $cart,
            'conditions' => $conditions,
            'subtotal' => $subtotal,
            'total' => $total,
        ];
    }

    public function totalItems()
    {
        $this->recalculateCart();
        $this->setShipping();

        $cartItems = $this->get()->map(function ($item) {
            return [
                'product_id' => $item['product_id'],
                'name' => $item['name'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'options' => $item['options'],
            ];
        });


        $condtionItems = $this->condtions()->map(function ($item){
            return [
                'name' => $item->getName(),
                'type' => $item->getType(),
                'price' => (float)$item->getValue(),
                'quantity' => 1,
            ];
        });

        $items = $cartItems->merge($condtionItems);

        return $items;
    }

}
