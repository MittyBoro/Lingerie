<?php

namespace App\Contracts;

use Illuminate\Support\Collection;

interface OrderInterface
{

    public function getAmount();

    public function getCurrency();

    public function getDescription();

    public function getId();

    public function getUUID();

    public function getCustomerName();

    public function getCustomerEmail();

    public function getCustomePhone();

    public function getItems(): Collection;

    public function getPaymentData();

    public function redirectUrl();

    public function setPaymentData($value);

    public function setStatus($value);

}
