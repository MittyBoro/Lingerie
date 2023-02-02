<?php

namespace App\Models;

use App\Events\ProductOrderPaid;
use App\Models\Traits\DateTrait;
use App\Models\Traits\RetrievingTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Propaganistas\LaravelPhone\PhoneNumber;


class Order extends Model
{
    use RetrievingTrait;
    use DateTrait;

    protected $casts = [
        'address' => 'array',
        'payment_data' => 'array',
    ];

    protected $fillable = [
        'cart_id',
        'uuid',
        'user_id',
        'payment_type',
        'payment_data',
        'name',
        'phone',
        'email',
        'address',
        'comment',
        'amount',
        'currency',
        'status',
    ];

    const STATUS_PENDING  = 'pending';
    const STATUS_SUCCESS  = 'success';
    const STATUS_CANCELED = 'canceled';
    const STATUS_REFUNDED = 'refunded';

    public static function boot()
    {
        parent::boot();

        static::saving( function($model)
        {
            if ($model->status != $model->getOriginal('status')) {
                // if ($model->status == self::STATUS_SUCCESS) {
                //     event(new ProductOrderPaid($model));
                // }
            }
        });
    }

    public static function statuses()
    {
        return [
            self::STATUS_PENDING,
            self::STATUS_SUCCESS,
            self::STATUS_CANCELED,
            self::STATUS_REFUNDED,
        ];
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id')->with('product');
    }

    public function setPhoneAttribute($value)
    {
        // не очень важно
        try {
            $this->attributes['phone'] = PhoneNumber::make($value)->formatE164();
        } catch (\Throwable $e) {

        }
    }

    public function getIsPaidAttribute()
    {
        return $this->status == self::STATUS_SUCCESS;
    }

    public function scopeIsPaid($query)
    {
        $query->where('status', self::STATUS_SUCCESS);
    }

    public function scopeSumAndCount($query)
    {
        return $query
                ->isPaid()
                ->selectRaw('SUM(`amount`) as `sum`, COUNT(*) AS `count`, `currency`')
                ->groupBy('currency')
                ->get();
    }

    public function setSuccess()
    {
        $this->update([
            'status' => self::STATUS_SUCCESS,
        ]);
    }
    public function setCanceled()
    {
        $this->update([
            'status' => self::STATUS_CANCELED,
        ]);
    }
    public function setPending()
    {
        $this->update([
            'status' => self::STATUS_PENDING
        ]);
    }
    public function setRefunded()
    {
        $this->update([
            'status' => self::STATUS_REFUNDED
        ]);
    }



    public static function createOrder($data)
    {
        $order = DB::transaction(function () use ($data) {
            $data['uuid'] = Str::uuid();
            $order = self::create($data);
            $order->items()->createMany($data['items']);

            return $order;
        });

        return $order;
    }


}
