<?php

namespace App\Services\Api;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class DolyameApi
{

	private string $url = "https://partner.dolyame.ru/v1/orders/";

	private string $login;
	private string $password;

	public function __construct($login, $password)
	{
		$this->login = $login;
		$this->password = $password;
	}

	public function create(array $data)
	{
		$postData = [
			...$data,
		];

		return $this->request('post', 'create', $postData);
	}

	public function info($orderNumber)
	{
		$url = $orderNumber . '/info';
		$result = $this->request('get', $url);

		return $result;
	}

	public function refund($orderNumber, $postData)
	{
		$url = $orderNumber . '/refund';
		$result = $this->request('post', $url, $postData);

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

		$cert = storage_path('app/dolyame/open-api-cert.pem');
		$sslKkey = storage_path('app/dolyame/private.key');

		$request = Http::withBasicAuth($this->login, $this->password)
						->acceptJson()
						->withOptions([
							'cert' => $cert,
							'ssl_key' => $sslKkey,
						])
						->withHeaders([
							'X-Correlation-ID' => (string) Str::orderedUuid(),
						]);

		$response = $request->$method($url, $data);

		if (!$response->ok()) {
			logger()->error('Error Dolyame', [$addUrl, $data, $response->json()]);
			throw new \Exception("Error Processing Dolyame Request");
		}


		return $response->json();
	}

}
