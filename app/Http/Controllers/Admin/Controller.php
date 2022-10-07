<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

abstract class Controller extends BaseController
{
    protected function validateSort(Request $request, $tableName)
    {
        $validated = $request->validate([
            'sorted' => 'required|array',
            'sorted.*.id' => 'required|exists:' . $tableName . ',id',
            'sorted.*.position' => 'required|integer',
        ]);

        return $validated['sorted'];
    }
}
