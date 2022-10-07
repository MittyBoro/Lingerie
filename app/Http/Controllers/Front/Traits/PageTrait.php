<?php

namespace App\Http\Controllers\Front\Traits;

use App\Models\Page;

trait PageTrait
{

    public function getPage($slug, $abortIfNull = true)
    {
        $page = Page::bySlug($slug, $abortIfNull);

        return $page;
    }

}
