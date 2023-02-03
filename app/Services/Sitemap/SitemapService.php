<?php

namespace App\Services\Sitemap;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Page;
use Arr;

class SitemapService
{

    public static function generate()
    {
        $sitemap = Sitemap::create();


        foreach (config('app.langs') as $lang) {

            self::generateByLang($sitemap, $lang);

        }


        $sitemap->writeToFile(public_path('sitemap.xml'));

        return response(true);
    }

    private static function generateByLang($sitemap, $lang)
    {
        $products = Product::isPublished()->get();

        $pageSlugs = ['delivery', 'catalog', 'faq', ];
        $pages = Page::whereIn('slug', $pageSlugs)->get()->unique('slug');

        $shopUpd = $products->sortBy('updated_at')->last()->updated_at;

        $categories = ProductCategory::getAllCategories(Product::class);


        $sitemap->add(
                self::createUrl('/', $lang, Carbon::yesterday(), Url::CHANGE_FREQUENCY_WEEKLY, 1)
            );


        $pages->each(function ($item) use ($sitemap, $shopUpd, $lang) {
            $updated_at = $item->slug == 'catalog' ? $shopUpd : $item->updated_at;

            $sitemap->add(
                    self::createUrl($item->slug, $lang, $updated_at, Url::CHANGE_FREQUENCY_MONTHLY, 0.8)
                );
        });


        $products->each(function ($item) use ($sitemap, $lang) {
            $sitemap->add(
                    self::createUrl("product/{$item->slug}", $lang, $item->updated_at, Url::CHANGE_FREQUENCY_MONTHLY, 0.6)
                );
        });

        $categories->each(function ($item) use ($sitemap, $shopUpd, $lang) {
            $sitemap->add(
                    self::createUrl("categories/{$item->slug}", $lang, $shopUpd, Url::CHANGE_FREQUENCY_MONTHLY, 0.4)
                );
        });
    }

    private static function createUrl($url, $lang, $lasModify, $frequency, $priority)
    {
        $newUrl = trim("$lang/$url", '/');

        $createdUrl = Url::create($newUrl)
                      ->setLastModificationDate($lasModify)
                      ->setChangeFrequency($frequency)
                      ->setPriority($priority);


        foreach (config('app.langs') as $alt) {
            $altUrl = trim("$alt/$url", '/');

            $createdUrl->addAlternate($altUrl, $alt);

        }

        return $createdUrl;
    }


}
