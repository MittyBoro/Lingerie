<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use App\Models\Admin\Prop;

class PropRequest extends AdminFormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $rules = [
            'key'   => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'tab'   => 'nullable|string|max:255',
        ];

        if ( $this->has('index_edit') )
            return $rules;

        return [
            ...$rules,
            'type'       => ['required', 'string', Rule::in(array_keys(Prop::TYPES))],
            'model_id'   => 'nullable',
            'model_type' => [
                            'nullable',
                            'string',
                            Rule::in( Prop::allowedModelTypes() )
                        ],
        ];
    }

}
