<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FeedbackOrder;
use Illuminate\Http\Request;

use Illuminate\Validation\Rule;

class FeedbackOrderController extends Controller
{

    public function create(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'string|nullable',
            'phone'   => 'string|nullable',
            'email'   => 'string|nullable',
            'city'    => 'string|nullable',
            'comment' => 'string|nullable',
            'form'    => ['required', 'string', Rule::in(array_keys(FeedbackOrder::FORM_TYPES))],
        ]);

        if (count($validated) < 2)
        {
            return [
                'success' => false,
                'message' => 'Заполнены не все данные',
            ];
        }

        $validated['user_hash'] = array_hash($request->ip(), $request->server('HTTP_USER_AGENT'));


        $canCreate = FeedbackOrder::canCreate($validated['user_hash']);

        if (!$canCreate)     {
            return [
                'success' => false,
                'message' => 'Повторите попытку позже',
            ];
        }

        FeedbackOrder::create($validated);
        return [
            'success' => true,
        ];
    }

}
