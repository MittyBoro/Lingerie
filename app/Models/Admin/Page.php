<?php

namespace App\Models\Admin;

use App\Models\Page as Model;
use App\Models\Traits\RetrievingTrait;
use Illuminate\Database\Eloquent\Builder;


class Page extends Model
{
    use RetrievingTrait;

    protected $sortable = ['slug', 'lang', 'title'];

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
