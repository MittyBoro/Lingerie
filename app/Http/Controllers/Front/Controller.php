<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller as BaseController;

abstract class Controller extends BaseController
{
    protected $page;

    public function __construct()
    {

    }
}
