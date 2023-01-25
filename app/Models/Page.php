<?php

namespace App\Models;

use App\Models\Traits\RetrievingTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;
    use RetrievingTrait;

    protected $fillable = [
        'slug',
        'lang',
        'title',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'view',
    ];

    protected $hidden = [
        'properties',
    ];

    public function properties()
    {
        return $this->morphMany(Prop::class, 'model')->with('media')
                    ->select( 'id', 'key', 'model_type', 'model_id', 'type', 'value_string', 'value_text' )
                    ;

    }

    public function getPropsAttribute()
    {
        return $this->properties->keyBy('key')
                                ->map(function($item) {
                                    return $item->value;
                                });
    }

    public function scopeFindForFront($query, $slug, $lang)
    {
        $page = $query
                ->where('slug', $slug)
                ->whereLang($lang)
                ->with('properties')
                ->firstOrFail(
                    ['id','view','slug','title','description','meta_title','meta_description','meta_keywords'],
                );

        if ($page)
            $page->append('props');

        return $page;
    }

    public function scopeGetFrontList($query, $lang)
    {
        $result = $query
                    ->whereLang($lang)
                    ->whereIn('slug', [
                        'catalog',
                        'categories',
                        'delivery',
                        'faq',
                        'cart',
                        'policy',
                    ])
                    ->get(['title', 'slug'])
                    ->keyBy('slug')
                    ->map(fn($v) => $v->title);

        return $result;
    }


}
