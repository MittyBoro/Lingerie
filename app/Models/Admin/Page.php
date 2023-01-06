<?php

namespace App\Models\Admin;

use App\Models\Page as BasePage;
use Illuminate\Database\Eloquent\Builder;


class Page extends BasePage
{

    protected static function booted()
    {
        static::addGlobalScope('ordered', function (Builder $builder) {
            $builder->orderBy('slug');
            $builder->orderBy('lang');
        });
    }

    public function props()
    {
        return app(BasePage::class)->morphMany(Prop::class, 'model')->with('media');
    }

    public function getAltLangsAttribute()
    {
        $pages = self::where('slug', $this->slug)
                    ->where('lang', '!=', $this->lang)
                    ->get(['lang', 'id']);
        return $pages;
    }


    public function saveAfter($data)
    {
        if ( isset($data['props']) ) {
            Prop::updateList($data['props']);
        }
    }

}
