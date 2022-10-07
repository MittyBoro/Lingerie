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
            'is_stock'     => 'required|boolean',
        ];

        if ( $this->has('index_edit') )
            return $rules;

        $rules += [
            'slug'         => 'required|string|unique:products,slug,'.$id,

            'categories'   => 'nullable|array',
            'categories.*' => 'exists:categories,id',

            ...$this->validationFiles('gallery', 'dimensions:min_width=400,min_height=400'),


            'description'             => 'nullable|string',

            'characteristics'         => 'nullable|array',
            'characteristics.*.name'  => 'required|string',
            'characteristics.*.value' => 'required|string',


            'variations'         => 'array|min:1',
            'variations.*.id'    => 'nullable|exists:product_variations,id',
            'variations.*.name'  => 'nullable|string',
            'variations.*.value' => 'nullable|string',
            'variations.*.price' => 'required|numeric',
            'variations.*.bonuses' => 'required|integer',

            'variations.*.promo_code_prices'                 => 'nullable|array',
            'variations.*.promo_code_prices.*.promo_code_id' => 'exists:promo_codes,id',
            'variations.*.promo_code_prices.*.price'         => 'numeric',


            ...$this->validationSEO(),
        ];

        return $rules;

    }

    public function attributes()
    {
        return [
            'is_published' => '«Опубликовано?»',
            'category_id'  => 'Категория',
            'slug'         => 'Ссылка',
        ];
    }

    public function messages()
    {
        return [
        ];
    }
}
