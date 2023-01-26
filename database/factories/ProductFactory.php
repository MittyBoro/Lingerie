<?php

namespace Database\Factories;

use App\Models\Admin\Product;
use App\Models\Admin\ProductCategory;
use App\Models\ProductAttribute;
use Database\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        return [
            'is_stock' => 1,
            'is_published' => !!rand(0, 5),
            'slug' => $this->faker->unique()->word,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $data = [
                'categories' => $this->getCategories(),
                'translations' => $this->getTranslations(),
                'attributes' => $this->getAttributes(),
                'gallery' => $this->getGallery(rand(1, 3)),
            ];

            $product->saveAfter($data);
        });
    }

    private function getCategories()
    {
        return ProductCategory::limit( rand(1,4) )->inRandomOrder()->pluck('id');
    }

    private function getAttributes()
    {
        return ProductAttribute::limit( rand(4,20) )->inRandomOrder()->pluck('id');
    }

    private function getTranslations()
    {
        return array_map(fn ($lang) => $this->getOneTranslation($lang), config('app.langs'));
    }
    private function getOneTranslation($lang)
    {
        $title = $this->faker->unique()->sentence(rand(3,5));

        $data = [
            'title' => $title,
            'meta_title' => $title,
            'lang' => $lang,

            'price' => $lang == 'en' ? rand(50, 500) : rand(500, 3000),

            'texts' => [
                'description' => $this->faker->text,
                'composition' => $this->faker->text,
                'care' => $this->faker->text,
            ]
        ];

        return $data;
    }

}
