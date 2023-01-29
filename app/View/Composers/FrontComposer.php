<?php

namespace App\View\Composers;

use App\Models\Page;
use App\Models\ProductCategory;
use App\Models\Prop;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class FrontComposer
{
    private $lang;
    private $view;


    public function __construct()
    {
        $this->lang = App::getLocale();

    }

    public function compose(View $view)
    {
        $this->view = $view;
        // $props = Prop::list();

        $this->layoutValues();
        $this->currencies();


        $this->view->with([
            'viewName'  => $this->getViewName($view),
            // 'props'     => $props,
        ]);
    }

    private function layoutValues()
    {
        $pages      = Page::getFrontList($this->lang);
        $categories = ProductCategory::getFrontList($this->lang);

        $footerCategories = $categories->take(3);

        $cartCount = app('CartService')->count();

        $this->view->with([
            'pages'      => $pages->toArray(),
            'categories' => $categories->toArray(),
            'footerCategories' => $footerCategories->toArray(),
            'cartCount' => $cartCount,
        ]);
    }

    private function currencies()
    {
        $cy = config('app.currencies.' . $this->lang);

        $cySymb = $cy;

        if ($cy == 'rub')
            $cySymb = '₽';
        elseif ($cy == 'usd')
            $cySymb = '$';

        $this->view->with([
            'cy' => $cy,
            'cySymb' => $cySymb,
        ]);
    }

    private function getViewName()
    {
        $view_array = explode('.', $this->view->getName());
        $viewName = end($view_array);

        return $viewName;
    }
}