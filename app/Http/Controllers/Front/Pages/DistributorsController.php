<?php

namespace App\Http\Controllers\Front\Pages;

use Illuminate\Http\Request;

use App\Models\Partner;

class DistributorsController extends Controller
{

	public function index(Request $request)
	{

		// $cities = Partner::distributors()->get()
		// 		->map(function($item) {
		// 			// return $item->link_city;
		// 			return $item->link_city . ' => ' . in_city($item->link_city);
		// 		})->unique()->values()->all();


		$partners = Partner::distributors()
								->with('media')
								->publicSelect()
								->get()
								->each(function($item) {
									$item->information = $item->sorted_information;
								});

		return view('pages.distributors', [
			'page' => $this->page,
			'partners' => $partners,
		]);
	}

}
