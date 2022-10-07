<?php

namespace Database\Factories\Product;

use App\Models\Product\Product;
use App\Models\Product\PromoCode;
use App\Models\Category;
use Database\Factories\Factory;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $title = trim($this->faker->unique()->sentence(5), '.');

        $params = [];
        foreach (range(0, rand(2,5)) as $number)
        {
            $params[] = [
                'name' =>  $this->faker->sentence(rand(1, 2)),
                'value' =>  $this->faker->sentence(rand(7, 20)),
            ];
        }

        return [
            'user_id' => 1,

            'title' => $title,
            'slug' => $this->faker->slug,

            'is_stock' => !!rand(0, 5),
            'is_published' => !!rand(0, 5),

            'characteristics' => $params,
            'description' => Str::of($this->faker->text)->toHtmlString(),

            'meta_title' => $title,
            'meta_description' => $this->faker->text,
            'meta_keywords' => implode(', ', $this->faker->words),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $data = [
                'categories' => $this->getCategories(),
                'variations' => $this->getVariations(),
                // 'gallery' => $this->getGallery(),
            ];

            $product->saveRelations($data);
        });
    }

    private function getCategories()
    {
        return Category::limit( rand(1,4) )->inRandomOrder()->pluck('id');
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

    private function getPromoCodePrices($price)
    {
        $promoCodes = PromoCode::get();
        $values = [];

        $promoCodes->each(function ($item) use (&$values, $price) {
            $values[] = [
                'promo_code_id' => $item->id,
                'price' => $price - round(rand(100, 1000), -2),
            ];
        });

        return $values;
    }

    private function getGallery()
    {
        return array_fill(0, 2,
            [ 'url' => 'https://picsum.photos/500/500' ]
        );
    }
}
