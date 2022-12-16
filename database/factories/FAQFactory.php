<?php

namespace Database\Factories;

class FAQFactory extends Factory
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
        $description = $this->faker->text();

        return [
            'lang' => 'en',
            'title' => $title,
            'description' => $description,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($item) {
            $this->toLocale($item, ['title', 'description'], 'ru');
        });
    }

}
