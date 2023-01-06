<?php

namespace Database\Factories;

use App\Models\Admin\Prop;
use Illuminate\Support\Arr;

class PropFactory extends Factory
{

    protected $model = Prop::class;

    public function definition()
    {
        return [
            'tab' => Prop::DEFAULT_TAB,
            'type' => Arr::random(array_keys(Prop::TYPES)),
            'title' => $this->faker->sentence(rand(2,3)),
            'key' => $this->faker->unique()->word(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Prop $prop) {
            $value = [];
            $type = $prop->type;

            if ( $type == 'string' )
                $value['string'] = $this->faker->text();

            elseif ( $type == 'boolean' )
                $value['string'] = (bool) rand(0,1);

            elseif ( $type == 'image' )
                $value['images'] = $this->getGallery(1);
            elseif ( $type == 'images' )
                $value['images'] = $this->getGallery(rand(0, 3));
            elseif ( $type == 'file' )
                $value['files'] = $this->getGallery(1);
            elseif ( $type == 'files' )
                $value['files'] = $this->getGallery(rand(0, 3));

            elseif ( $type == 'text_array' )
                $value['text_array'] = $this->faker->words(rand(1, 4));
            else
                $value['text'] = $this->faker->realText();


            $prop->updateItem(['value' => $value]);
        });
    }

}
