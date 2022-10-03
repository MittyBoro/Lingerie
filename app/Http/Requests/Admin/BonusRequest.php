<?php

namespace App\Http\Requests\Admin;

class BonusRequest extends AdminFormRequest
{

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		$rules = [
			'title'  => 'required|string|max:255',
			'amount' => 'required|integer',
		];

		if ( $this->has('index_edit') )
			return $rules;

		$rules += [
			'end_at' => 'nullable|date',
			'user_id' => 'required|exists:users,id',
		];

		return $rules;
	}
}
