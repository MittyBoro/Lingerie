<?php

namespace Database\Factories;

use App\Models\Admin\Product;
use App\Models\Admin\ProductCategory;
use Database\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'is_stock' => 1,
            'is_published' => !!rand(0, 5),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $data = [
                'categories' => $this->getCategories(),
                'translations' => $this->getTranslations(),
                // 'variations' => $this->getVariations(),
                'gallery' => $this->getGallery(),
            ];

            $product->saveAfter($data);
        });
    }

    private function getCategories()
    {
        return ProductCategory::limit( rand(1,4) )->inRandomOrder()->pluck('id');
    }

    private function getVariations()
    {
        $list = [];

        $names = $this->faker->words( rand(1, 3) );

        $price = round(rand(300, 5000), -2) / 2;

        foreach($names as $name) {
            foreach(range(0, rand(0, 3)) as $v) {
                $list[] = [
                    'name' => $name,
                    'value' => $this->faker->word,
                    'price' => $price,
                    'promo_code_prices' => $this->getPromoCodePrices($price)
                ];
            }
        }

        return $list;
    }

    private function getTranslations()
    {
        return array_map(fn ($lang) => $this->getOneTranslation($lang), config('app.langs'));
    }
    private function getOneTranslation($lang)
    {
        $data = [
            'title' => $this->faker->unique()->sentence(rand(2,4)),
            'lang' => $lang,
            'slug' => $this->faker->unique()->word,
            'attributes' => [
                'description' => $this->faker->text,
                'composition' => $this->faker->text,
                'care' => $this->faker->text,
            ]
        ];

        return $data;
    }

    private function getGallery()
    {
        return array_fill(0, 3,
            // https://lorem.space/
            [ 'url' => 'https://api.lorem.space/image/fashion?w=500&h=500' ]
        );
    }
}
