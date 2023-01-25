<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Page;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;

abstract class Controller extends BaseController
{
    protected $page;
    protected $lang;

    public function __construct()
    {
        $this->lang = App::getLocale();

        $pages      = Page::getFrontList($this->lang)->toArray();
        $categories = ProductCategory::getFrontList($this->lang)->toArray();

        View::share('pages', $pages);
        View::share('categories', $categories);
    }

}
