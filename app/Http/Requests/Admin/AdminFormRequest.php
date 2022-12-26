<?php

namespace App\Http\Requests\Admin;


use App\Http\Requests\FormRequest;
use Illuminate\Validation\Rule;

class AdminFormRequest extends FormRequest
{

    protected function prepareForValidation()
    {
        if ($this->has('is_published'))
            $this->request->set('is_published', (bool)$this->is_published);

        parent::prepareForValidation();
    }

    public function attributes()
    {
        return [
        ];
    }

    protected function validationFiles($key, $fileRules): array
    {
        return [
            $key           => 'nullable|array',
            $key.'.*.id'   => 'nullable|exists:media,id',
            $key.'.*.file' => 'nullable|' . $fileRules,
            $key.'.*.del'  => 'nullable',
        ];
    }

    protected function validationSEO($preffix = ''): array
    {
        return [
            $preffix.'meta_title'       => 'string|nullable|max:255',
            $preffix.'meta_description' => 'string|nullable|max:255',
            $preffix.'meta_keywords'    => 'string|nullable|max:255',
        ];
    }

    protected function validationLang(): array
    {
        return [
            'lang' => lang_rule(),
        ];
    }
}
