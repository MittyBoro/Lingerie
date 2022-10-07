<?php

namespace App\Http\Requests\Admin;


use App\Http\Requests\Admin\AdminFormRequest;

use Illuminate\Validation\Rule;


class CategoryRequest extends AdminFormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $rules = [
            'title' => 'required|string|max:255',
            'slug' => [
                'required',
                'string',
                Rule::unique('categories')->ignore($this->id)->where(function ($query) {
                    $model = $this->request->get('model');
                    return $query
                        ->where('model_type', $model);
                }),
            ]
        ];

        if ( $this->has('index_edit') )
            return $rules;

        $rules += [
            'parent_id' => 'nullable|present|exists:categories,id',
            'description' => 'nullable|string',
            'footer_description' => 'nullable|string',

            ...$this->validationSEO(),
        ];

        return $rules;
    }

    public function attributes()
    {
        return [
            'parent_id' => 'Родитель',
            'slug'      => 'Ярлык',
        ];
    }

    public function messages()
    {
        return [

        ];
    }
}
