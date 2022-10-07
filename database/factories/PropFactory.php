<?php

namespace Database\Factories;

use App\Models\Prop;
use Illuminate\Support\Arr;

class PropFactory extends Factory
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
        return [
            'tab' => Arr::random([Prop::DEFAULT_TAB, 'Вкладка #2']),
            'type' => Arr::random(Prop::typeKeys()),
            'title' => $this->faker->sentence(rand(2,3)),
            'key' => $this->faker->unique()->word(),
        ];
    }
}
