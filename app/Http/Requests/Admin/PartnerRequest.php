<?php

namespace App\Http\Requests\Admin;


use App\Http\Requests\Admin\AdminFormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Factory as ValidationFactory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

use App\Models\Partner;


class PartnerRequest extends AdminFormRequest
{

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		$rules = [
			'person_name'  => 'required|string',
			'city'        => 'required|string',
			'company_name' => 'nullable|string',
			'address'     => 'nullable|string',

			'is_published' => 'boolean',
			'is_franchisee'  => 'boolean',
			'is_distributor' => 'boolean',
		];

		if ( $this->has('index_edit') )
			return $rules;

		$rules += [

			'description' => 'nullable|string',

			'information'         => 'nullable|array',
			'information.*.type'  => ['required', 'string', Rule::in(array_keys(Partner::INFO_TYPES))],
			'information.*.value' => 'required|string',
		];
		return $rules;

	}
}
