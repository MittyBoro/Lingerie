<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;

class Controller extends BaseController
{

    protected function updateSort(Request $request, $model, $addToValidate = [])
    {
        $tableName = $model->getTable();
        $validated = $request->validate([
            'sorted' => 'required|array',
            'sorted.*.id' => 'required|exists:' . $tableName . ',id',
            'sorted.*.position' => 'required|integer',
            ...$addToValidate
        ]);

        $data = $validated['sorted'];

        DB::transaction(function() use ($model, $data) {
            foreach($data as $v) {
                $model::where('id', $v['id'])->update($v);
            }
        });

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
