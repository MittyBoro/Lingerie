<?php

namespace Database\Factories;

use App\Models\Admin\ProductCategory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class ProductCategoryFactory extends Factory
{

    protected $model = ProductCategory::class;


    public function definition()
    {
        return [
            'position' => 0
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (ProductCategory $productCategory) {

            $data = [
                'translations' => $this->getTranslations(),
            ];
            $productCategory->saveAfter($data);


            if (!rand(0, 3))
                return;

            $productCategory->refresh();

            $parent = ProductCategory::whereNot('id', $productCategory->id)
                            ->withDepth()->having('depth', '=', 0)
                            ->inRandomOrder()->first();

            if ($parent->isDescendantOf($productCategory))
                return;

            $productCategory->parent_id = $parent->id;
            $productCategory->save();

            ProductCategory::fixTree();
        });
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
            'description' => $this->faker->text,
        ];

        return $data;
    }
}
