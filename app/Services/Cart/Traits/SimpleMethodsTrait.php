<?php

namespace App\Services\Cart\Traits;

use Cart;

trait SimpleMethodsTrait
{

    public function getSumWithoutDiscount()
    {
        $sum = $this->getContent()->sum(function ($item) {
            return $item->getPriceSum();
        });

        return $sum;
    }

    public function getSubTotal()
    {
        return Cart::getSubTotal();
    }

    public function getTotal()
    {
        return Cart::getTotal();
    }

    public function update($cart_id, array $data)
    {
        return Cart::update($cart_id, $data);
    }

    public function remove($cart_id)
    {
        return Cart::remove($cart_id);
    }

    public function clear()
    {
        return Cart::clear();
    }

}
