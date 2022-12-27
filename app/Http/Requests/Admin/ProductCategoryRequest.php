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
        return [
            'parent_id' => 'nullable|present|exists:categories,id',

            'translations' => 'required|array',
            'translations.*.id'    => 'nullable|exists:product_category_translations,id',
            'translations.*.lang'  => lang_rule(),
            'translations.*.title' => 'required|string|max:255',
            'translations.*.slug'  => 'required|string|max:255',
            'translations.*.description'  => 'nullable|string',

            ...$this->validationSEO('translations.*.'),
        ];
    }

}
