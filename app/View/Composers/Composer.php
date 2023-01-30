<?php

namespace App\View\Composers;

use App\Models\Page;
use App\Models\ProductCategory;
use App\Models\Prop;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

abstract class Composer
{
    protected $lang;

    public function __construct()
    {
        $this->lang = App::getLocale();
    }

}
