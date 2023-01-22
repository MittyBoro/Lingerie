<?php

namespace App\Models\Admin;

use App\Models\Page as Model;
use App\Models\Traits\RetrievingTrait;


class Page extends Model
{
    use RetrievingTrait;

    protected $sortable = ['slug', 'lang', 'title'];

    protected static function boot()
    {
        parent::boot();
        static::saving( function($query)
        {
            if ( empty($query->meta_title) )
                $query->meta_title = $query->title;
        });
    }

    public function props()
    {
        return app(Model::class)->morphMany(Prop::class, 'model')->with('media');
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
        if (array_key_exists('props', $data)) {
            Prop::updateList($data['props']);
        }
    }

}
