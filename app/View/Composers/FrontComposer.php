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
    private $view;

    public function compose(View $view)
    {
        $this->view = $view;


        $this->setLayoutValues();
        $this->setViewName();
    }

    private function setLayoutValues()
    {
        $props = Prop::getByKeys([
            'body_code',
            'head_code',
            'instagram',
        ]);

        $pages      = Page::getFrontList( locale() );
        $categories = ProductCategory::getFrontList( locale() );

        $footerCategories = $categories->take(3);

        $cartCount = app('cart')->count();

        $this->view->with([
            'props'      => $props->toArray(),
            'pages'      => $pages->toArray(),
            'categories' => $categories->toArray(),
            'footerCategories' => $footerCategories->toArray(),
            'cartCount' => $cartCount,
            'currentUrl' => url()->current(),
        ]);
    }

    private function setViewName()
    {
        $view_array = explode('.', $this->view->getName());
        $viewName = end($view_array);

        $this->view->with([
            'viewName'  => $viewName,
        ]);
    }
}
