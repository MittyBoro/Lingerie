<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
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
                    'value' => 'Нижнее белье для девушек, любящих своё тело',
                ],
                [
                    'type' => 'text',
                    'title' => 'О бренде - текст',
                    'key' => 'about_text',
                    'value' => 'Лорем',
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
                    'value' => 'Underwear for girls who love their body',
                ],
                [
                    'type' => 'text',
                    'title' => 'О бренде - текст',
                    'key' => 'about_text',
                    'value' => 'Lorem',
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



    }
}
