<?php

namespace App\Http\Requests\Admin;


use App\Http\Requests\Admin\AdminFormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Factory as ValidationFactory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;


class PostRequest extends AdminFormRequest
{

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		$id = $this->post ? $this->post->id : '';

		$rules = [
			'title'        => 'required|string|max:255',
			'is_published' => 'required|boolean',
		];

		if ( $this->has('index_edit') )
			return $rules;

		$rules += [
			'slug'         => 'required|string|max:255|unique:posts,slug,'.$id,
			'description'  => 'string|nullable',
			'published_at' => 'date',


			...$this->validationFiles('preview', 'dimensions:min_width=200,min_height=200'),

			'partner_id'   => 'nullable|exists:partners,id',

			...$this->validationFiles('photos', 'dimensions:min_width=200,min_height=200'),
			...$this->validationFiles('videos', 'mimetypes:video/webm,video/mpeg,video/mp4,video/quicktime,video/x-matroska'),


			...$this->validationSEO(),
		];

		return $rules;

	}
}
