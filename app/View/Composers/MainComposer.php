<?php

namespace App\View\Composers;

use App\Models\Page;
use App\Models\ProductCategory;
use App\Models\Prop;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class MainComposer
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

        $this->view->with([
            'pages'      => $pages->toArray(),
            'categories' => $categories->toArray(),
            'footerCategories' => $footerCategories->toArray(),
        ]);
    }

    private function getViewName()
    {
        $view_array = explode('.', $this->view->getName());
        $viewName = end($view_array);

        return $viewName;
    }
}
