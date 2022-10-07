<?php

namespace App\Http\Controllers\Front\Pages;

use App\Models\Page;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Agent\Agent;

abstract class Controller
{
    protected $page;

    public function __construct(Page $page)
    {
        $this->page = $page;
    }

    protected function replacePageData(Model|string $replaceData, string $replaceKey = '%replace%')
    {
        $keys2Replace = ['meta_title', 'meta_description', 'meta_keywords', 'title', 'description'];

        foreach ($keys2Replace as $key) {
            if (!$this->page->{$key})
                continue;

            if (is_string($replaceData)) {
                $this->replacePageKey($key, $replaceData, $replaceKey);
            } else {
                if ($replaceData->hasAttribute($key)) {
                    $this->replacePageKey($key,  $replaceData->{$key}, $replaceKey, true);
                }
            }
        }
    }
    protected function replacePageKey(string $key, $data, string $replaceKey, $replaceIfNot = false)
    {
        $pageValue = $this->page->{$key};

        if ($replaceIfNot && filled($data)) {
            if ( strrpos($pageValue, $replaceKey) === false ) {
                $this->page->{$key} = $data;
                return;
            }
        }
        $this->page->{$key} = str_replace($replaceKey, $data, $pageValue);
    }

}
