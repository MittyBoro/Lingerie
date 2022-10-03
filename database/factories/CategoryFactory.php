<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product\Product;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Course>
 */
class CategoryFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition()
	{
		$title = $this->faker->unique()->sentence(2);
		return [
			'title' => $title,
			'slug' => $title,
			'description' => $this->faker->paragraph(),
			'footer_description' => rand(0, 1) ? $this->faker->paragraph() : null,
			'model_type' => Product::class,
		];
	}


	public function configure()
	{
		return $this->afterCreating(function (Category $category) {

			if (!rand(0, 3))
				return;

			$category->refresh();

			$parent = Category::whereNot('id', $category->id)->inRandomOrder()->first();

			if ($parent->isDescendantOf($category))
				return;

			$category->parent_id = $parent->id;
			$category->save();

			Category::fixTree();
		});
	}
}
