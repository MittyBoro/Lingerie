<?php

namespace App\Services\Payment;

use App\Models\Product\ProductOrder;

class Payment
{
    private $payment;
    private $paymentType;

    public function __construct(?string $paymentType)
    {
        $this->paymentType = $paymentType;
        if ($paymentType == 'yookassa')
            $this->payment = new YooKassa();
        else
            throw new \Exception('Invalid payment type');
    }

    public function create(ProductOrder $model)
    {
        $data = $this->getSimpleData($model);
        $newPayment = $this->payment->create($data, $this->getBackUrl($data['order_id']));

        if (isset($newPayment['id']) && isset($newPayment['url']))
            $model->update([
                'payment_id' => $newPayment['id'],
                'url'        => $newPayment['url'],
            ]);
        else
            throw new \Exception('Ошибка создания платежа');

        return \Arr::only($newPayment, 'url');
    }

    public function updateStatus(ProductOrder $model)
    {
        if ($model->payment_id)
            $status = $this->payment->status($model->payment_id);
        else
            $status = ProductOrder::STATUS_CANCELED;

        $this->changeModelStatus($model, $status);
    }


    public function refund(ProductOrder $model)
    {
        if (!$model->payment_id)
            throw new \Exception("Заказ невозможно вернуть, нет платёжного id");

        try {
            if (! method_exists($this->payment, 'refund'))
                return;

            $refund = $this->payment->refund($model->payment_id, $model->toArray());
            if (!$refund)
                throw new \Exception("Заказ невозможно вернуть, метод refund не вернул нужный ответ");

            $model->update(['payment_data' => $refund]);

        } catch (\Throwable $e) {
            logger()->error($e->getMessage());
            throw new \Exception("Заказ не получилось вернуть #2");
        }
    }


    public function webhook(): void
    {
        $data = $this->payment->webhook();

        if (isset($data['id'])) {
            $model = ProductOrder::findOrFail($data['id']);
        } elseif(isset($data['payment_id'])) {
            $model = ProductOrder::where([
                'payment_id' => $data['payment_id'],
                'payment_type' => $this->paymentType,
            ])->firstOrFail();
        } else {
            throw new \Exception("Error webhook " . $this->paymentType);
        }

        $this->changeModelStatus($model, $data['status']);
    }


    private function getSimpleData($model)
    {
        $data = [
            'amount' => $model->amount,
            'order_id' => $model->id,
            'delivery' => $model->delivery,
            'customer' => [
                'name' => $model->name,
                'email' => $model->email,
                'phone' => $model->phone,
            ],
        ];

        $data['items'] = $model->items->map(function($item) {
            return [
                'name' => $item->name,
                'quantity' => $item->quantity,
                'amount' => $item->discount_price ?: $item->price,
            ];
        });

        return $data;
    }

    private function changeModelStatus(ProductOrder $model, $status)
    {
        if ($status == ProductOrder::STATUS_SUCCESS) {
            $model->setSuccess();
        } elseif ($status == ProductOrder::STATUS_REFUNDED) {
            $model->setRefunded();
        } elseif ($status == ProductOrder::STATUS_CANCELED) {
            $model->setCanceled();
        }
    }

    private function getBackUrl($id)
    {
        return route('front.payment.return', $id);
    }


}
