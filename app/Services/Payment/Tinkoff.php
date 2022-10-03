<?php

namespace App\Services\Payment;

use App\Models\Product\ProductOrder;
use App\Services\Api\TinkoffApi;

class Tinkoff
{
	private $client;

	public function __construct()
	{
		$this->client = new TinkoffApi(
				config('payment.tinkoff.shop_id'),
				config('payment.tinkoff.showcase_id'),
				config('payment.tinkoff.password'),
				config('payment.tinkoff.is_demo'),
			);
	}

	public function create($data, $returnUrl): array
	{
		$orderNumber = 'AV-' . $data['order_id'];
		$requestData = [
			'sum' => $data['amount'],
			// 'promoCode' => '',
			'items' => $this->getItemsArray($data['items'], $data['delivery']),
			'orderNumber' => $orderNumber,
			'failURL' => $returnUrl,
			'successURL' => $returnUrl,
			'returnURL' => $returnUrl,
			'webhookURL' => route('front.payment.webhook', 'tinkoff'),
			// 'webhookURL' => 'https://4913-185-140-161-4.eu.ngrok.io/payment/webhook/tinkoff',
			'values' => [
				'contact' => [
					'fio' => $data['customer']['name'],
					'mobilePhone' => $data['customer']['phone'],
					'email' => $data['customer']['email'],
				]
			],
		];

		try {
			$response = $this->client->create($requestData);

			if (!isset($response['id'])) {
				throw new \Exception('Tinkoff id не получен');
			}

			return [
				'id' => $orderNumber,
				'url' => $response['link'],
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
				'name' => $item['name'],
				'quantity' => $item['quantity'],
				'price' => $item['amount'],
			];
		}

		if ( $delivery > 0 )
		{
			$items4Kassa[] = [
				'name' => 'Доставка',
				'quantity' => 1,
				'price' => $delivery,
			];
		}

		return $items4Kassa;
	}

	public function status($paymentId)
	{
		try {
			$payment = $this->client->info($paymentId);
			if (is_array($payment))
				return $this->getStatusByKey( $payment['status'] );
			else
				return ProductOrder::STATUS_CANCELED;
		} catch (\Exception $e) {
			return ProductOrder::STATUS_CANCELED;
		}
	}

	public function webhook(): array
	{
		$source = file_get_contents('php://input');
		$requestBody = json_decode($source, true);

		if (!$requestBody || !is_array($requestBody) || !isset($requestBody['status']))
			throw new \Exception('Ошибка получения webhook данных');

		return [
			'payment_id' => $requestBody['id'],
			'status' => $this->getStatusByKey( $requestBody['status'] ),
		];
	}

	private function getStatusByKey($key)
	{
		if ($key == 'signed')
			return ProductOrder::STATUS_SUCCESS;
		elseif (in_array($key, ['canceled', 'rejected']))
			return ProductOrder::STATUS_CANCELED;
		else
			return ProductOrder::STATUS_PENDING;
	}
}
