<?php

namespace Database\Seeders;

use App\Models\Admin\ProductCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = $this->getCategories();

        foreach ($categories as $cat) {
            $this->createCategory($cat);
        }
    }

    private function createCategory($catItem)
    {
        $children = $catItem['children'] ?? [];

        $catItem['translations'] =
                    Arr::map($catItem['translations'], function ($arr) {
                        $arr['meta_title'] = $arr['title'];
                        return $arr;
                    });

        $productCategory = ProductCategory::create(
                                Arr::except($catItem, ['children', 'translations'])
                            );

        if (!empty($children))
            $catItem['preview'] = [ [ 'url' => 'https://api.lorem.space/image/fashion?w=500&h=500' ] ];

        $productCategory->saveAfter($catItem);

        foreach ($children as $cat) {
            $cat['parent_id'] = $productCategory->id;

            $this->createCategory($cat);
        }
    }

    private function getCategories()
    {
        $cats = [];

        $cats[] = [
            'slug' => 'underwear',
            'translations' => [
                [ 'title' => 'Нижнее белье', 'lang' => 'ru', ],
                [ 'title' => 'Underwear', 'lang' => 'en', ],
            ],
            'children' => [
                [
                    'slug' => 'bra',
                    'translations' => [
                        [ 'title' => 'Бюстгальтеры', 'lang' => 'ru', ],
                        [ 'title' => 'Bra', 'lang' => 'en', ],
                    ],
                ],
                [
                    'slug' => 'panties',
                    'translations' => [
                        [ 'title' => 'Трусики', 'lang' => 'ru', ],
                        [ 'title' => 'Panties', 'lang' => 'en', ],
                    ],
                ],
                [
                    'slug' => 'belts',
                    'translations' => [
                        [ 'title' => 'Пояса', 'lang' => 'ru', ],
                        [ 'title' => 'Belts', 'lang' => 'en', ],
                    ],
                ],
                [
                    'slug' => 'linen_sets',
                    'translations' => [
                        [ 'title' => 'Комплекты', 'lang' => 'ru', ],
                        [ 'title' => 'Linen sets', 'lang' => 'en', ],
                    ],
                ]
            ]
        ];


        $cats[] = [
            'slug' => 'swimwear',
            'translations' => [
                [ 'title' => 'Купальники', 'lang' => 'ru', ],
                [ 'title' => 'Swimwear', 'lang' => 'en', ],
            ],
            'children' => [
                [
                    'slug' => 'swimsuit',
                    'translations' => [
                        [ 'title' => 'Слитные', 'lang' => 'ru', ],
                        [ 'title' => 'Swimsuit', 'lang' => 'en', ],
                    ],
                ],
                [
                    'slug' => 'separate',
                    'translations' => [
                        [ 'title' => 'Раздельные', 'lang' => 'ru', ],
                        [ 'title' => 'Separate', 'lang' => 'en', ],
                    ],
                ],
            ],
        ];


        $cats[] = [
            'slug' => 'homewear',
            'translations' => [
                [ 'title' => 'Для дома', 'lang' => 'ru', ],
                [ 'title' => 'Homewear', 'lang' => 'en', ],
            ],
            'children' => [
                [
                    'slug' => 'pajamas',
                    'translations' => [
                        [ 'title' => 'Пижамы', 'lang' => 'ru', ],
                        [ 'title' => 'Pajamas', 'lang' => 'en', ],
                    ],
                ],
                [
                    'slug' => 'bathrobes',
                    'translations' => [
                        [ 'title' => 'Халаты', 'lang' => 'ru', ],
                        [ 'title' => 'Bathrobes', 'lang' => 'en', ],
                    ],
                ],
            ],
        ];


        return $cats;
    }
}
