<?php

namespace App\Services;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Carbon\Carbon;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Page;

class SitemapService
{

    public static function generate()
    {
        $products = Product::isPublished()->get();

        $pageSlugs = ['delivery', 'catalog', 'faq', ];
        $pages = Page::whereIn('slug', $pageSlugs)->get();

        $shopUpd = $products->sortBy('updated_at')->last()->updated_at;

        $categories = ProductCategory::getAllCategories(Product::class);

        $sitemap = Sitemap::create()
                                ->add(Url::create('/')
                                    ->setLastModificationDate(Carbon::yesterday())
                                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
                                    ->setPriority(1));


        $pages->each(function ($item) use ($sitemap, $shopUpd) {
            $updated_at = $item->slug == 'catalog' ? $shopUpd : $item->updated_at;

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

        $categories->each(function ($item) use ($sitemap, $shopUpd) {
            $sitemap->add(Url::create("/categories/{$item->slug}")
                            ->setLastModificationDate($shopUpd)
                            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                            ->setPriority(0.4));
        });


        $sitemap->writeToFile(public_path('sitemap.xml'));

        return response(true);
    }

}
