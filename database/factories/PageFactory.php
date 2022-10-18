<?php

namespace Database\Factories;

use App\Models\Page;
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
            'lang' => 'en',
            'slug' => $this->faker->unique()->word,
            'route' => Arr::random(['about', 'contact', 'home', '']),
            'description' => $this->faker->text,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Page $page) {

            $pageAlt = $page->replicate()->fill([
                'lang' => 'ru',
                'title' => latin_to_cyrillic($page['title']),
                'description' => latin_to_cyrillic($page['description']),
            ]);

            $pageAlt->save();
        });
    }

}
