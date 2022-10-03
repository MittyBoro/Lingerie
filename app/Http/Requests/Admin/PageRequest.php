<?php

namespace App\Http\Requests\Admin;

class PageRequest extends AdminFormRequest
{

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		$id = $this->page ? $this->page->id : '';

		$rules = [
			'title'       => 'nullable|string|max:255',
			'slug'        => 'required|string|max:255|unique:pages,slug,'.$id,
			// 'is_hidden'   => 'required|boolean',
			'description' => 'string|nullable',
			'route'       => 'nullable|string',

			...$this->validationSEO(),
		];

		return $rules;
	}
}
