<?php

namespace Database\Seeders;

use App\Models\Admin\Page;
use App\Models\Admin\Prop;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class PageSeeder extends Seeder
{
    public function run()
    {
        $pages = $this->getData();

        foreach ($pages as $page) {
            $this->createPage($page);
        }
    }

    private function createPage($pageItem)
    {
        $props = $pageItem['props'] ?? [];

        $pageItem = Arr::except($pageItem, 'props');

        $page = Page::create($pageItem);

        foreach ($props as $prop) {
            $prop += [
                'model_type' => \App\Models\Page::class,
                'model_id' => $page->id,
            ];
            Prop::create($prop);
        }
    }

    private function getData()
    {
        /**
         * home
         * catalog
         * product
         * cart
         * order
         * checkout
         * delivery
         * faq
         * success
         */

        $pages = [];

        // home
        $pages[] = [
            'title' => 'Legendary Lingerie',
            'slug' => 'home',
            'view' => 'home',
            'lang' => 'ru',
            'props' => [
                [
                    'type' => 'text',
                    'title' => 'Заголовок на главной',
                    'key' => 'home_title',
                    'value_text' => 'Нижнее белье для девушек, любящих своё тело',
                ],
                [
                    'type' => 'format_text',
                    'title' => 'О бренде - текст',
                    'key' => 'about_text',
                    'value_text' => 'Лорем',
                ],
            ],
        ];
        $pages[] = [
            'title' => 'Legendary Lingerie',
            'slug' => 'home',
            'view' => 'home',
            'lang' => 'en',
            'props' => [
                [
                    'type' => 'text',
                    'title' => 'Заголовок на главной',
                    'key' => 'home_title',
                    'value_text' => 'Underwear for girls who love their body',
                ],
                [
                    'type' => 'format_text',
                    'title' => 'О бренде - текст',
                    'key' => 'about_text',
                    'value_text' => 'Lorem',
                ],
            ],
        ];


        // catalog
        $pages[] = [
            'title' => 'Каталог',
            'slug' => 'catalog',
            'view' => 'catalog',
            'lang' => 'ru',
            'meta_title' => '%replace% | Legendary Lingerie',
            'meta_keywords' => '%replace%',
            'meta_description' => '%replace%',
        ];
        $pages[] = [
            'title' => 'Catalog',
            'slug' => 'catalog',
            'view' => 'catalog',
            'lang' => 'en',
            'meta_title' => '%replace% | Legendary Lingerie',
            'meta_keywords' => '%replace%',
            'meta_description' => '%replace%',
        ];


        // product
        $pages[] = [
            'title' => 'Товар',
            'slug' => 'product',
            'view' => 'product',
            'lang' => 'ru',
            'meta_title' => '%replace% | Legendary Lingerie',
            'meta_keywords' => '%replace%',
            'meta_description' => '%replace%',
        ];
        $pages[] = [
            'title' => 'Товар',
            'slug' => 'product',
            'view' => 'product',
            'lang' => 'en',
            'meta_title' => '%replace% | Legendary Lingerie',
            'meta_keywords' => '%replace%',
            'meta_description' => '%replace%',
        ];


        // cart
        $pages[] = [
            'title' => 'Ваша корзина',
            'slug' => 'cart',
            'view' => 'cart',
            'lang' => 'ru',
            'meta_title' => 'Cart | Legendary Lingerie',
        ];
        $pages[] = [
            'title' => 'Your cart',
            'slug' => 'cart',
            'view' => 'cart',
            'lang' => 'en',
            'meta_title' => 'Cart | Legendary Lingerie',
        ];


        // checkout
        $pages[] = [
            'title' => 'Оформление заказа',
            'slug' => 'checkout',
            'view' => 'checkout',
            'lang' => 'ru',
            'meta_title' => 'Оформление заказа | Legendary Lingerie',
        ];
        $pages[] = [
            'title' => 'Checkout',
            'slug' => 'checkout',
            'view' => 'checkout',
            'lang' => 'en',
            'meta_title' => 'Checkout | Legendary Lingerie',
        ];


        // faq
        $pages[] = [
            'title' => 'FAQ',
            'slug' => 'faq',
            'view' => 'faq',
            'lang' => 'ru',
            'meta_title' => 'FAQ | Legendary Lingerie',
        ];
        $pages[] = [
            'title' => 'FAQ',
            'slug' => 'faq',
            'view' => 'faq',
            'lang' => 'en',
            'meta_title' => 'FAQ | Legendary Lingerie',
        ];


        // delivery
        $pages[] = [
            'title' => 'Доставка',
            'slug' => 'delivery',
            'lang' => 'ru',
            'description' => 'Доставка',
            'meta_title' => 'Доставка | Legendary Lingerie',
        ];
        $pages[] = [
            'title' => 'Delivery',
            'slug' => 'delivery',
            'lang' => 'en',
            'description' => 'Delivery',
            'meta_title' => 'Delivery | Legendary Lingerie',
        ];


        // success
        $pages[] = [
            'title' => 'Заказ оформлен',
            'slug' => 'success',
            'view' => 'success',
            'lang' => 'ru',
        ];
        $pages[] = [
            'title' => 'Order is processed',
            'slug' => 'success',
            'view' => 'success',
            'lang' => 'en',
        ];


        // politic
        $pages[] = [
            'title' => 'Политика конфиденциальности',
            'slug' => 'politic',
            'view' => 'politic',
            'lang' => 'ru',
            'description' => 'Политика конфиденциальности',
        ];
        $pages[] = [
            'title' => 'Privacy Policy',
            'slug' => 'politic',
            'view' => 'politic',
            'lang' => 'Privacy Policy',
        ];

        return $pages;
    }
}
