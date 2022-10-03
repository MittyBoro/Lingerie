<?php

namespace App\Services;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;

use App\Models\Product\Product;
use App\Models\Category;
use App\Models\Page;
use App\Models\Post;

class SitemapService
{

	public static function generate()
	{
		$products = Product::isPublished()->get();
		$news = Post::isPublished()->get();

		$pageSlugs = ['about', 'shop', 'news', 'contacts', 'franchisee', 'distributors', 'contract', 'franchising', ];
		$pages = Page::whereIn('slug', $pageSlugs)->get();

		$cities = Cities::list();

		$shopUpd = $products->sortBy('updated_at')->last()->updated_at;

		$categories = Category::getAllCategories(Product::class);

		$sitemap = Sitemap::create()
								->add(Url::create('/')
									->setLastModificationDate(Carbon::yesterday())
									->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
									->setPriority(1));


		$pages->each(function ($item) use ($sitemap, $shopUpd) {
			$updated_at = $item->slug == 'shop' ? $shopUpd : $item->updated_at;

			$sitemap->add(Url::create("/{$item->slug}")
							->setLastModificationDate($updated_at)
							->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
							->setPriority(0.8));
		});


		$products->each(function ($item) use ($sitemap) {
			$sitemap->add(Url::create("/product/{$item->slug}")
							->setLastModificationDate($item->updated_at)
							->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
							->setPriority(0.6));
		});

		$news->each(function ($item) use ($sitemap) {
			$sitemap->add(Url::create("/article/{$item->slug}")
							->setLastModificationDate($item->updated_at)
							->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
							->setPriority(0.4));
		});

		$categories->each(function ($item) use ($sitemap, $shopUpd) {
			$sitemap->add(Url::create("/category/{$item->slug}")
							->setLastModificationDate($shopUpd)
							->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
							->setPriority(0.4));
		});

		$cities->each(function ($item) use ($sitemap, $shopUpd) {
			$sitemap->add(Url::create("/city-shop/{$item['slug']}")
							->setLastModificationDate($shopUpd)
							->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
							->setPriority(0.4));
		});


		$sitemap->writeToFile(public_path('sitemap.xml'));

		return response(true);
	}

}
