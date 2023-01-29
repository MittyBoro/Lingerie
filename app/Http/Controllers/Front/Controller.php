<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller as BaseController;
use App\Models\Page;
use Illuminate\Database\Eloquent\Model;

abstract class Controller extends BaseController
{

    protected function replacePageData(Page $page, Model|string $replaceData, string $replaceKey = '%replace%')
    {
        $keys2Replace = ['meta_title', 'meta_description', 'meta_keywords', 'title', 'description'];

        foreach ($keys2Replace as $key) {
            if (!$page->{$key})
                continue;

            $data = is_string($replaceData) ? $replaceData : $replaceData->{$key};

            $this->replacePageKey($page, $key, $data, $replaceKey);
        }

        return $page;
    }
    protected function replacePageKey(Page $page, string $key, $data, string $replaceKey, $replaceIfNot = false)
    {
        $pageValue = $page->{$key};

        if ($replaceIfNot && filled($data)) {
            if ( strrpos($pageValue, $replaceKey) === false ) {
                $page->{$key} = $data;
                return;
            }
        }
        $page->{$key} = str_replace($replaceKey, $data, $pageValue);
    }

}

