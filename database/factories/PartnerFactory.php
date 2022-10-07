<?php

namespace Database\Factories;

use Illuminate\Support\Arr;

class PartnerFactory extends Factory
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
        $city = $this->faker->city();
        $information = [];
        foreach (range(0, rand(0,3)) as $v)
        {
            $information[] = Arr::random([
                ['type' => 'text', 'value' => 'Текст'],
                ['type' => 'url', 'value' => '#'],
                ['type' => 'vk', 'value' => '#'],
                ['type' => 'instagram', 'value' => '#'],
                ['type' => 'phone', 'value' => '+7 000 000 00 00'],
            ]);
        }

        return [
            'user_id' => 1,

            'person_name' => $this->fakeRuName(),
            'city' => $city,
            'company_name' => 'Студия AleVi в городе ' . $city,
            'address' => $this->faker->streetAddress(),

            'description' => $this->faker->text,
            'information' => $information,

            'is_franchisee' => !!rand(0, 3),
            'is_distributor' => !!rand(0, 5),
            'is_published' => !!rand(0, 5),
        ];

    }
}
