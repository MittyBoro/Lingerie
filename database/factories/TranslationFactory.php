<?php

namespace Database\Factories;

use Illuminate\Support\Str;

class TranslationFactory extends Factory
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
        $value = trim($this->faker->unique()->sentence(rand(2,4)), '.');

        return [
            'lang' => 'en',
            'key' => Str::snake($this->faker->unique()->words(rand(1,3), true)),
            'value' => $value,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function ($item) {
            $this->toLocale($item, ['value'], 'ru');
        });
    }

}
