<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use App\Models\Prop;

class PropRequest extends AdminFormRequest
{

	public function authorize()
	{
		return true;
	}

	public function rules()
	{
		if ( $this->has('value_edit') ) {

			return $this->rules4Values();
		}

		$rules = [
			'key'   => 'required|string|max:255',
			'title' => 'required|string|max:255',
			'tab'   => 'nullable|string|max:255',
		];

		if ( $this->has('index_edit') )
			return $rules;

		return [
			...$rules,
			'type'       => ['required', 'string', Rule::in(Prop::typeKeys())],
			'model_id'   => 'nullable',
			'model_type' => [
							'nullable',
							'string',
							Rule::in( Prop::allowedModelTypes() )
						],
		];
	}

	private function rules4Values()
	{
		$type = $this->prop ? $this->prop->type : null;

		if ($type == 'boolean') {
			$rules['admin_value'] = 'boolean';
		}
		elseif (in_array($type, ['file', 'files'])) {
			$rules = [
				...$this->validationFiles('admin_value', 'file'),
			];
		}
		else {
			$rules['admin_value'] = 'nullable|string';
		}
		return $rules;
	}

}
