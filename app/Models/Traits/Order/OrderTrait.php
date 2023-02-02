<?php

namespace App\Models\Traits\Order;

use Illuminate\Support\Collection;

trait OrderTrait
{
    public function getPaymentType()
    {
        return $this->payment_type;
    }
    public function getAmount()
    {
        return $this->amount;
    }

    public function getCurrency()
    {
        return $this->amount;
    }

    public function getDescription()
    {
        return 'Order #'. $this->id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getUUID()
    {
        return $this->uuid;
    }

    public function getCustomerName()
    {
        return $this->name;
    }

    public function getCustomerEmail()
    {
        return $this->email;
    }

    public function getCustomePhone()
    {
        return $this->phone;
    }

    public function getItems(): Collection
    {
        return $this->items;
    }

    public function getPaymentData()
    {
        return $this->payemnt_data;
    }

    public function setPaymentData($value)
    {
        $this->update([
            'payemnt_data' => $value,
        ]);
    }

    public function setStatus($status)
    {
        $this->update([
            'status' => $status,
        ]);
    }
}
