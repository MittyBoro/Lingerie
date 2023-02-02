<?php

namespace App\Payments;

use App\Models\Order;
use App\Contracts\PaymentInterface;

use YooKassa\Client;
use YooKassa\Model\Notification\NotificationFactory;

class YooKassaPayment implements PaymentInterface
{
    private $order;
    private $client;

    public function __construct(Order $order)
    {
        $this->order = $order;

        $this->client = new Client();
        $this->client->setAuth( config('payment.yookassa.shop_id'), config('payment.yookassa.secret_key') );
    }

    public function charge($returnUrl = null)
    {
        $this->order->setStatus(self::STATUS_PENDING);
        return;


        try {
            $idempotenceKey = uniqid('', true);
            $response = $this->client->createPayment(
                [
                    'amount' => [
                        'value' => $data['amount'],
                        'currency' => 'RUB',
                    ],
                    'confirmation' => [
                        'type' => 'redirect',
                        'locale' => 'ru_RU',
                        'return_url' => $returnUrl,
                    ],
                    'capture' => true,
                    'description' => 'Заказ #' . $data['order_id'],
                    'metadata' =>[
                        'order_id' => $data['order_id'],
                    ],
                    'receipt' => [
                        'customer' => [
                            'full_name' => $data['customer']['name'],
                            'email' => $data['customer']['email'],
                            'phone' => $data['customer']['phone'],
                        ],
                        'items' => $this->getItemsArray($data['items'], $data['delivery']),
                    ],
                ],
                $idempotenceKey
            );

            $id = $response->getId();

            if (!$id) {
                throw new \Exception('YooKassa id не получен');
            }

            return [
                'id' => $id,
                'url' => $response->getConfirmation()->getConfirmationUrl(),
            ];

        } catch (\Throwable $e) {
            logger()->error($e->getMessage());
            throw $e;
        }

    }


    private function getItemsArray($items, $delivery)
    {
        $items4Kassa = [];

        foreach($items as $item)
        {
            $items4Kassa[] = [
                'description' => $item['name'],
                'quantity' => $item['quantity'],
                'amount' => [
                    'value' => $item['amount'],
                    'currency' => 'RUB'
                ],
                'vat_code' => '1',
                'payment_mode' => 'full_payment',
                'payment_subject' => 'commodity',
            ];
        }

        if ( $delivery > 0 )
        {
            $items4Kassa[] = [
                'description' => 'Доставка',
                'quantity' => 1,
                'amount' => [
                    'value' => $delivery,
                    'currency' => 'RUB'
                ],
                'vat_code' => '1',
                'payment_mode' => 'full_payment',
                'payment_subject' => 'service',
            ];
        }

        return $items4Kassa;
    }

    public function check()
    {
        $this->order->setStatus(self::STATUS_SUCCESS);
        return;

        try {
            $payment = $this->client->getPaymentInfo($paymentId);
            return $this->getStatusByKey( $payment->getStatus() );
        } catch (\Exception $e) {
            logger()->error($e->getMessage());
            return Order::STATUS_CANCELED;
        }
    }

    public function redirectUrl() {}

    public function webhook()
    {
        $this->order->setStatus(self::STATUS_SUCCESS);
        return;

        $source = file_get_contents('php://input');
        $requestBody = json_decode($source, true);

        if (!$requestBody || !is_array($requestBody) || !isset($requestBody['event']))
            throw new \Exception('Ошибка получения webhook данных');

        try {
            $factory = new NotificationFactory();
            $notification = $factory->factory($requestBody);
            $payment = $notification->getObject();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            throw new \Exception('Ошибка получения webhook данных #2');
        }

    }
}
