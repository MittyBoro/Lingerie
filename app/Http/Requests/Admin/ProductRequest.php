<?php

namespace App\Http\Requests\Admin;


use App\Http\Requests\Admin\AdminFormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Factory as ValidationFactory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;


class ProductRequest extends AdminFormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {

        $id = $this->product ? $this->product->id : '';

        $rules = [
            'is_published' => 'required|boolean',
            // 'is_stock'     => 'required|boolean',
        ];

        if ( $this->has('index_edit') )
            return $rules;

        $rules += [
            'slug' => 'required|string|max:255|unique:products,slug,'.$id,

            'translations' => 'required|array|min:1',
            'translations.*.id'    => 'nullable|exists:product_translations,id',
            'translations.*.title' => 'required|string|max:255',
            'translations.*.price' => 'required|numeric|min:0',
            'translations.*.lang'  => lang_rule(),
            'translations.*.details'             => 'required|array',
            'translations.*.details.description' => 'nullable|string',
            'translations.*.details.composition' => 'nullable|string',
            'translations.*.details.care'        => 'nullable|string',

            'categories'   => 'nullable|array',
            'categories.*' => 'exists:product_categories,id',

            'options'   => 'nullable|array',
            'options.*' => 'exists:product_options,id',

            ...$this->validationSEO('translations.*.'),


            ...$this->validationFiles('gallery', 'dimensions:min_width=400,min_height=400'),
            ...$this->validationFiles('size_table', 'dimensions:min_width=300,min_height=300'),

        ];

        return $rules;
    }

}
