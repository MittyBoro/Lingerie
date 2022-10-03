<?php

namespace App\Services\Payment;

use App\Models\Product\ProductOrder;
use App\Services\Api\DolyameApi;
use Illuminate\Support\Str;

class Dolyame
{
	private $client;

	public function __construct()
	{
		$this->client = new DolyameApi(
				config('payment.dolyame.login'),
				config('payment.dolyame.password'),
			);
	}

	public function create($data, $returnUrl): array
	{
		$orderID = (string)Str::orderedUuid();
		$requestData = [
			'order' => [
				'id' => $orderID,
				'amount' => $data['amount'],
				'items' => $this->getItemsArray($data['items'], $data['delivery']),
			],
			'client_info' => [
				'phone' => $data['customer']['phone'],
				'email' => $data['customer']['email'],
			],
			'fail_url' => $returnUrl,
			'success_url' => $returnUrl,
			'notification_url' => route('front.payment.webhook', 'dolyame'),
			// 'notification_url' => 'https://6812-185-140-163-185.eu.ngrok.io/payment/webhook/dolyame',
		];

		try {
			$response = $this->client->create($requestData);

			if (!isset($response['link'])) {
				throw new \Exception('Dolyame «link» не получен');
			}

			return [
				'id' => $orderID,
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
				'price' => $item['amount'] ?? $item['price'],
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

			if (isset($payment['refund_info']))
				return ProductOrder::STATUS_REFUNDED;

			return $this->getStatusByKey( $payment['status'] );

		} catch (\Exception $e) {
			return ProductOrder::STATUS_CANCELED;
		}
	}

	public function refund($paymentId, $modelData): array
	{
		$postData = [
			'amount' => $modelData['amount'],
			'returned_items' => $this->getItemsArray($modelData['items'], $modelData['delivery'])
		];

		$refund = $this->client->refund($paymentId, $postData);

		if (!isset($refund['refund_id'])) {
			logger()->error('Error Dolyame', [$paymentId, $refund]);
			throw new \Exception("Dolyame Refund Error");
		}

		return $refund;
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
		if ($key == 'completed')
			return ProductOrder::STATUS_SUCCESS;
		elseif (in_array($key, ['canceled', 'rejected']))
			return ProductOrder::STATUS_CANCELED;
		else
			return ProductOrder::STATUS_PENDING;
	}
}
