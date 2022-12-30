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

    protected function toLocaleItem($text, $to = 'ru')
    {
        return $to == 'ru' ?
                latin_to_cyrillic( $text ):
                cyrillic_to_latin( $text );
    }

}
