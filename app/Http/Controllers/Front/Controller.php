<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Page;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

abstract class Controller extends BaseController
{
    protected $lang;

    protected function getLang()
    {
        return App::getLocale();
    }

}
