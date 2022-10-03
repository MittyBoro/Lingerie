<?php

namespace App\Services;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;

use App\Models\Product\Product;
use App\Models\Product\ProdCategory;
use App\Models\News;
use App\Models\Page;
use App\Models\Partner;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class Cities
{
	public static function find($slug)
	{
		return self::list()->firstWhere('slug', $slug);
	}

	public static function list($byCount = false)
	{
		$cacheName = $byCount ? 'cities_list_by_count' : 'cities_list';

		$list = Cache::rememberForever($cacheName, function () use ($byCount) {
			return Partner::cities($byCount)->map(function($item) {

				$city = preg_replace("/(,|\().*/i", '', $item);
				$city = preg_replace("/^^((пос|город|гор|п|г))(\s|\.)/i", '', $city);
				$city = trim($city);


				$prepositional = self::prepositional($city);

				if (in_array(mb_strtolower($city), ['владимир', 'владивосток']))
					$in = 'во ';
				else
					$in = 'в ';

				// dump($city .'     ' . $item);
				return [
					'slug' => Str::slug($city),
					'name' => $city,
					'original_name' => $item,
					'prepositional' => $in . $prepositional,
				];
			});
		});

		self::forgetCache();

		return $list;
	}


	public static function prepositional($city)
	{
		$city = trim($city);
		$cityLower = mb_strtolower($city);

		$ignoreCities = ['кутаиси','тольятти','бородино', 'улан-удэ', 'сочи'];

		if (in_array($cityLower, $ignoreCities))
			return $city;

		$cityCustom = [
			'комсомольск-на-амуре' => 'Комсомольске-на-Амуре',
			'ростов-на-дону' => 'Ростове-на-Дону',
			'набережные челны' => 'Набережных Челнах',
			'нижний новгород' => 'Нижнем Новгороде',
			'щучье' => 'Щучьем',
			'ливны' => 'Ливнах',
			'нижний ломов' => 'Нижнем Ломове',
			'орёл' => 'Орле',
			'орел' => 'Орле',
			'чебоксары' => 'Чебоксарах',
		];

		if (isset($cityCustom[$cityLower]))
			return $cityCustom[$cityLower];

		if ( rtrim($city, 'о') != $city) {
			return $city;
		}

		if ( preg_replace('/(нь|мь|рь)$/i', '', $city) != $city ) {
			$city = rtrim($city, 'ь') . 'и';
			return $city;
		}

		if ( ( $newCity = preg_replace('/(ое|ий|ый|ой)$/i', 'ом', $city) ) != $city ) {
			return $newCity;
		}

		if ( ( $newCity = preg_replace('/(ец)$/i', 'це', $city) ) != $city ) {
			return $newCity;
		}

		$city = preg_replace('/(у|е|а|э|я|и|ь|ю|й|ю)$/i', '', $city);
		$city .= 'е';

		return $city;
	}

	public static function forgetCache()
	{
		Cache::forget('cities_list');
		Cache::forget('cities_list_by_count');
	}

}
