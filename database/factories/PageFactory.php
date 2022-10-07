<?php

namespace Database\Factories;

use Illuminate\Support\Arr;

class PageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = trim($this->faker->unique()->sentence(rand(2,4)), '.');

        return [
            'title' => $title,
            'slug' => $this->faker->unique()->word,
            'route' => Arr::random(['about', 'contact', 'home']),
            'description' => $this->faker->text,
            'is_hidden' => !!rand(0, 4),
        ];
    }

}
