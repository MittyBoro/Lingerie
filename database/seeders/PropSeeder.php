<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Admin\Prop;

class PropSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->getData() as $prop) {
            Prop::create($prop);
        }
    }

    private function getData()
    {
        $props = [];

        $props[] = [
            'tab' => Prop::DEFAULT_TAB,
            'type' => 'string',
            'key' =>'instagram',
            'title' => 'Ссылка на Instagram',
            'value' => ['string' => 'https://www.instagram.com/'],
        ];

        $props[] = [
            'tab' => Prop::DEFAULT_TAB,
            'type' => 'string',
            'key' =>'notification_email',
            'title' => 'Email для оповещений',
            'value' => ['string' => 'iboro770@gmail.com'],
        ];


        $props[] = [
            'tab' => Prop::DEFAULT_TAB,
            'type' => 'string',
            'key' =>'free_shipping_rub',
            'title' => 'Бесплатная доставка от, ₽',
            'value' => ['string' => '1000000'],
        ];
        $props[] = [
            'tab' => Prop::DEFAULT_TAB,
            'type' => 'string',
            'key' =>'shipping_rub',
            'title' => 'Цена доставки, ₽',
            'value' => ['string' => '1000'],
        ];

        $props[] = [
            'tab' => Prop::DEFAULT_TAB,
            'type' => 'string',
            'key' =>'free_shipping_usd',
            'title' => 'Бесплатная доставка от, $',
            'value' => ['string' => '1000000'],
        ];
        $props[] = [
            'tab' => Prop::DEFAULT_TAB,
            'type' => 'string',
            'key' =>'shipping_usd',
            'title' => 'Цена доставки, $',
            'value' => ['string' => '100'],
        ];

        return $props;

    }
}
