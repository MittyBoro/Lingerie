<?php

namespace App\Http\Requests\Admin;


use App\Http\Requests\Admin\AdminFormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Factory as ValidationFactory;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;


class ProductCategoryRequest extends AdminFormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = $this->product_category?->id ?: '';

        return [
            'parent_id' => 'nullable|present|exists:product_categories,id',
            'slug'      => 'required|string|max:255|unique:product_categories,slug,'.$id,

            'translations' => 'required|array|min:1',
            'translations.*.id'    => 'nullable|exists:product_category_translations,id',
            'translations.*.lang'  => lang_rule(),
            'translations.*.title' => 'required|string|max:255',
            'translations.*.description'  => 'nullable|string',

            ...$this->validationSEO('translations.*.'),

            ...$this->validationFiles('preview', 'dimensions:min_width=250,min_height=250'),
        ];
    }

}
