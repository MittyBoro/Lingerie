<?php

namespace App\Http\Requests\Admin;

use Illuminate\Validation\Rule;
use App\Models\Admin\Prop;

class PropListRequest extends AdminFormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'props.*.id'       => 'required|exists:props,id',
            'props.*.title'    => 'required|string|max:222',
            'props.*.key'      => 'required|string|max:222',
            'props.*.position' => 'required|numeric',
            'props.*.type'     => ['required', 'string', Rule::in(array_keys(Prop::TYPES))],

            'props.*.value'    => 'array|min:1',
            'props.*.value.text'       => 'nullable|string',
            'props.*.value.string'     => 'nullable|string|max:255',
            'props.*.value.text_array' => 'nullable|array',
            ...$this->validationFiles('props.*.value.images', 'dimensions:min_width=50,min_height=50'),
            ...$this->validationFiles('props.*.value.files', 'file'),
        ];
    }

}
