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

}
