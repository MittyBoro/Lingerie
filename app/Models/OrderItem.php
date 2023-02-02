<?php

namespace App\Models;

use App\Models\Admin\Product;
use App\Models\Traits\Order\OrderItemTrait;
use App\Contracts\OrderItemInterface;
use Illuminate\Database\Eloquent\Model;


class OrderItem extends Model implements OrderItemInterface
{
    use OrderItemTrait;

    public $timestamps = false;

    protected $casts = [
        'options' => 'array',
    ];

    protected $fillable = [
        'order_id',
        'product_id',
        'name',
        'price',
        'quantity',
        'options',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class)->with('media');
    }


}
