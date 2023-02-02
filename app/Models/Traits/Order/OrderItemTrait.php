<?php

namespace App\Models\Traits\Order;

trait OrderItemTrait
{
    public function getAmount()
    {
        return $this->price;
    }

    public function getName()
    {
        $name = $this->name;

        if ($this->options) {
            $name .= ': '. $this->options->pluck('string')->implode(', ');
        }
        return $name;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }
}
