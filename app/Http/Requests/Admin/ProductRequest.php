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
            'title'        => 'required|string|max:255',
            'is_published' => 'required|boolean',
            // 'is_stock'     => 'required|boolean',
        ];

        if ( $this->has('index_edit') )
            return $rules;

        $rules += [
            'slug' => 'required|string|max:255|unique:products,slug,'.$id,
            'lang' => lang_rule(),

            ...$this->validationFiles('gallery', 'dimensions:min_width=400,min_height=400'),

            'attributes'             => 'required|array',
            'attributes.description' => 'required|string',
            'attributes.composition' => 'required|string',
            'attributes.care'        => 'required|string',

            // 'categories'   => 'nullable|array',
            // 'categories.*' => 'exists:categories,id',

            // 'variations'         => 'array|min:1',
            // 'variations.*.id'    => 'nullable|exists:product_variations,id',
            // 'variations.*.name'  => 'nullable|string',
            // 'variations.*.value' => 'nullable|string',
            // 'variations.*.price' => 'required|numeric',
            // 'variations.*.bonuses' => 'required|integer',

            ...$this->validationSEO(),
        ];

        return $rules;
    }

}
