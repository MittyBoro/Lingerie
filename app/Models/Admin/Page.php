<?php

namespace App\Models\Admin;

use App\Models\Page as BasePage;
use Illuminate\Database\Eloquent\Builder;


class Page extends BasePage
{

    protected static function booted()
    {
        static::addGlobalScope('ancient', function (Builder $builder) {
            $builder->orderBy('slug');
            $builder->orderBy('lang');
        });
    }

    public function getAltLangsAttribute()
    {
        $pages = self::where('slug', $this->slug)
                    ->where('lang', '!=', $this->lang)
                    ->get(['lang', 'id']);
        return $pages;
    }

}