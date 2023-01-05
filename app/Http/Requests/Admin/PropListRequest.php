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
            'props.*.value'    => 'nullable',
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
