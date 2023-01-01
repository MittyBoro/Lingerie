<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;

class Controller extends BaseController
{

    protected function validateSort(Request $request, $tableName, $addToValidate = [])
    {
        $validated = $request->validate([
            'sorted' => 'required|array',
            'sorted.*.id' => 'required|exists:' . $tableName . ',id',
            'sorted.*.position' => 'required|integer',
            ...$addToValidate
        ]);

        return $validated['sorted'];
    }

    public function setListLang(Request $request)
    {
        Cookie::queue(
            Cookie::forever('admin_lang', $request->lang)
        );

        return back();
    }

    public function getListLang()
    {
        $lang = admin_lang();

        if ( in_array($lang, config('app.langs')) )
            $lang = $lang;
        else
            $lang = null;

        return $lang;
    }

}
