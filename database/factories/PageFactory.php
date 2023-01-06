<?php

namespace Database\Factories;

use App\Models\Admin\Page;
use App\Models\Admin\Prop;
use Illuminate\Support\Arr;

class PageFactory extends Factory
{

    protected $model = Page::class;

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
            $this->toLocale($page, ['title', 'description'], 'ru');

            Prop::whereNull('model_id')
                ->limit( rand(0,3) )
                ->get()
                ->each(fn ($item) => $item->update([
                    'model_type' => \App\Models\Page::class,
                    'model_id' => $page->id,
                ]));
        });
    }

}
