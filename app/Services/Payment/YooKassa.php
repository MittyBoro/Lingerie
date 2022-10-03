<?php

namespace App\Services\Payment;

use App\Models\Product\ProductOrder;

use YooKassa\Client;
use YooKassa\Model\Notification\NotificationFactory;

class YooKassa
{
	private $client;

	public function __construct()
	{
		$this->client = new Client();
		$this->client->setAuth( config('payment.yookassa.shop_id'), config('payment.yookassa.secret_key') );
	}

	public function create($data, $returnUrl): array
	{
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

	public function status($paymentId)
	{
		try {
			$payment = $this->client->getPaymentInfo($paymentId);
			return $this->getStatusByKey( $payment->getStatus() );
		} catch (\Exception $e) {
			logger()->error($e->getMessage());
			return ProductOrder::STATUS_CANCELED;
		}
	}

	public function webhook(): array
	{
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

		return [
			'id' => $payment->getMetadata()['order_id'],
			'status' => $this->getStatusByKey( $payment->getStatus() ),
		];
	}

	private function getStatusByKey($key)
	{
		if ($key == 'succeeded')
			return ProductOrder::STATUS_SUCCESS;
		elseif ($key == 'canceled')
			return ProductOrder::STATUS_CANCELED;
		else
			return ProductOrder::STATUS_PENDING;
	}
}
