<?php

namespace App\Http\Requests;
use Illuminate\Support\Arr;


use Illuminate\Foundation\Http\FormRequest as MainRequest;


class FormRequest extends MainRequest
{
	public function attributes()
	{
		return [
			'image' => 'Изображение',
			'images' => 'Изображения',
			'photo' => 'Фото',
			'photos' => 'Фотографии',
			'is_premium' => 'Премиум',
		];
	}
}
