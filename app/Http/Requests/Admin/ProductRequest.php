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
            'translations' => 'required|array',
            'translations.*.id'    => 'nullable|exists:product_translations,id',
            'translations.*.title' => 'required|string|max:255',
            'translations.*.slug'  => 'required|string|max:255',
            'translations.*.lang'  => lang_rule(),
            'translations.*.attributes'             => 'required|array',
            'translations.*.attributes.description' => 'required|string',
            'translations.*.attributes.composition' => 'required|string',
            'translations.*.attributes.care'        => 'required|string',

            ...$this->validationSEO('translations.*.'),


            ...$this->validationFiles('gallery', 'dimensions:min_width=400,min_height=400'),
            ...$this->validationFiles('size_table', 'dimensions:min_width=300,min_height=300'),


            // 'categories'   => 'nullable|array',
            // 'categories.*' => 'exists:categories,id',

            // 'variations'         => 'array|min:1',
            // 'variations.*.id'    => 'nullable|exists:product_variations,id',
            // 'variations.*.name'  => 'nullable|string',
            // 'variations.*.value' => 'nullable|string',
            // 'variations.*.price' => 'required|numeric',
            // 'variations.*.bonuses' => 'required|integer',

        ];

        return $rules;
    }

}
