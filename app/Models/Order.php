<?php

namespace App\Models;

use App\Events\ProductOrderPaid;

use App\Contracts\OrderInterface;
use App\Contracts\PaymentStatusInterface;

use App\Models\Traits\DateTrait;
use App\Models\Traits\Order\OrderTrait;
use App\Models\Traits\RetrievingTrait;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Propaganistas\LaravelPhone\PhoneNumber;


class Order extends Model implements PaymentStatusInterface, OrderInterface
{
    use RetrievingTrait;
    use DateTrait;
    use OrderTrait;

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
        'lang',
        'status',
    ];

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
