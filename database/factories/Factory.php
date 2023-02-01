<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory as MainFactory;
use Illuminate\Support\Arr;

abstract class Factory extends MainFactory
{
    protected function fakeRuName($gender = null)
    {
        $gender = $gender ?: Arr::random(['male', 'female']);

        $firstName = $this->faker->firstName($gender);
        $lastName = rtrim( $this->faker->lastName(), 'а' );

        if ($gender == 'female') {
            $lastName .= 'а';
        }

        return $firstName . ' ' . $lastName;
    }


    protected function toLocale($model, $fields = [], $to = 'ru')
    {
        $data = ['lang' => $to];

        foreach ($fields as $field) {
            $data[ $field ] = $this->toLocaleItem( $model[ $field ] );
        }

        $modelAlt = $model->replicate()->fill($data);
        $modelAlt->save();
    }

    protected function toLocaleArray($array, $to = 'ru', array $ignoreKeys = null)
    {
        array_walk_recursive($array, function (&$item, $key) use ($to, $ignoreKeys) {
            if ( !in_array($key, $ignoreKeys) && is_string($item) ) {
                $item = $this->toLocaleItem($item, $to);
            }
        });
        return $array;
    }

    protected function toLocaleItem($text, $to = 'ru')
    {
        return $to == 'ru' ?
                latin_to_cyrillic( $text ):
                cyrillic_to_latin( $text );
    }

    protected function getGallery($count)
    {
        // return [];
        return array_fill(0, $count,
            // https://lorem.space/
            [ 'url' => 'https://api.lorem.space/image/fashion?w=500&h=500' ]
        );
    }

}
