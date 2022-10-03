<?php

namespace App\Services\Api;

use Illuminate\Support\Facades\Http;


class TinkoffApi
{

	private string $url = "https://forma.tinkoff.ru/api/partners/v2/orders/";

	private string $shopId;
	private string $showcaseId;
	private string $login;
	private string $password;
	private bool $isDemo;

	public function __construct($shopId, $showcaseId, $password, $isDemo = false)
	{
		$this->shopId = $shopId;
		$this->showcaseId = $showcaseId;
		$this->login = $isDemo ? 'demo-'.$showcaseId : $showcaseId;
		$this->password = $password;
		$this->isDemo = $isDemo;
	}

	public function create(array $data)
	{
		$postData = [
			'shopId' => $this->shopId,
			'showcaseId' => $this->showcaseId,
			...$data,
		];

		$method = $this->isDemo ? 'create-demo' : 'create';

		return $this->request('post', $method, $postData);
	}

	public function info($orderNumber)
	{
		$url = $orderNumber . '/info';

		$result = $this->request('get', $url);

		return $result;
	}


	/**
	 *
	 *
	 * create
	 * Create Demo
	 * info
	 */


	// solid, ага
	private function request($method, string $addUrl, ?array $data = null)
	{
		$url = $this->url . $addUrl;

		$request = Http::withBasicAuth($this->login, $this->password)
						->acceptJson();

		$response = $request->$method($url, $data);

		if (!$response->ok() && $response->status() != 404) {
			logger()->error('Error Tinkoff', [$addUrl, $data, $response->json()]);
			throw new \Exception("Error Processing Tinkoff Request");
		}

		return $response->json();
	}

}
