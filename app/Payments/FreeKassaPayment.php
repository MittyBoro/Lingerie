<?php

namespace App\Payments;

use App\Models\Order;
use App\Contracts\PaymentInterface;

use App\Services\PaymentAPI\FreeKassaService;

class FreeKassaPayment implements PaymentInterface
{
    private $order;
    private $client;

    public function __construct(Order|null $order)
    {
        $this->order = $order;

        $this->client = new FreeKassaService(config('payment.drivers.freekassa.shop_id'), config('payment.drivers.freekassa.api_key'));
    }

    public function charge($returnUrl = null)
    {
        $this->order->setStatus(self::STATUS_PENDING);

        try {
            $response = $this->client->createOrder([
                'paymentId' => $this->order->getId(),
                'email' => $this->order->getCustomerEmail(),
                'ip' => request()->ip(),
                'amount' => $this->order->getAmount(),
                'currency' => $this->order->getCurrency(),

                'success_url' => $this->redirectUrl(),
                'failure_url' => $this->backUrl(),
            ]);

            dd($response);

            $url = $response['location'];

            $this->order->setPaymentData($response);

            return [
                'id' => $this->order->getId(),
                'url' => $url,
            ];

        } catch (\Throwable $e) {
            logger()->error($e->getMessage());
            throw $e;
        }
    }

    public function check()
    {
        $status = $this->order->getStatus();

        if ($status != self::STATUS_PENDING) {
            return;
        }

        try {
            $order = $this->client->getOrder($this->order->getId());

            logger()->info('check', $order);die;


            $this->setStatusByCode($order['status']);

        } catch (\Exception $e) {

            $orderData = $this->order->getPaymentData();

            $orderData['exceptions_count'] = ($orderData['exceptions_count'] ?? 0) + 1;

            if ($orderData['exceptions_count'] > 5) {
                $this->order->setStatus(self::STATUS_CANCELED);
            }

            logger()->error($e->getMessage());
        }

        return;
    }



    public function webhook()
    {
        $data = request()->all();

        logger()->info('webhook', $data);


        abort(403);
        return ;


        $this->order->setStatus(self::STATUS_SUCCESS);

        //

        // if (!$requestBody || !is_array($requestBody) || !isset($requestBody['event']))
        //     throw new \Exception('Ошибка получения webhook данных');

        // try {
        //     $factory = new NotificationFactory();
        //     $notification = $factory->factory($requestBody);
        //     $payment = $notification->getObject();
        // } catch (\Exception $e) {
        //     \Log::error($e->getMessage());
        //     throw new \Exception('Ошибка получения webhook данных #2');
        // }

    }


    private function setStatusByCode($code)
    {
        if ($code == 0) {
            // pending
        }
        elseif ($code == 1) {
            $this->order->setStatus(self::STATUS_SUCCESS);
        }
        else {
            $this->order->setStatus(self::STATUS_CANCELED);
        }
    }

    public function redirectUrl()
    {
        return $this->order->getPaymentData()['location'] ?? null;
    }



    public function backUrl()
    {
        return route('front.orders', [
            'lang' => $this->order->lang,
            'order' => $this->order->uuid]
        );
    }
}
