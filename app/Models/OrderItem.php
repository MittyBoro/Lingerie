<?php

namespace App\Models;

use App\Models\Product\Product;

class OrderItem extends BaseModel
{
    public $timestamps = false;

    protected $casts = [
        'variations' => 'array',
    ];

    protected $appends = [
        'sum_old_price',
        'sum_price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class)->with('media');
    }

    public function getSumOldPriceAttribute()
    {
        return $this->price * $this->quantity;
    }

    public function getSumPriceAttribute()
    {
        return ($this->discount_price ?: $this->price) * $this->quantity;
    }
}
