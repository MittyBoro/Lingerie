<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

abstract class Controller extends BaseController
{
    protected $page;

    public function __construct()
    {

    }

}
