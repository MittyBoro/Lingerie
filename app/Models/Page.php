<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;

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
        return app(self::class)->morphMany(Prop::class, 'model')->with('media');
    }

    public function getPropsAttribute()
    {
        return $this->props()->get()->keyBy('key')
                                ->map(function($item) {
                                    return $item->value;
                                });
    }

    public function scopeFindBySlug($query, $slug, $abortIfNull = true)
    {
        $page = $query
                ->where('slug', $slug)
                ->with('props')
                ->firstOr(
                    ['id','view','slug','title','description','meta_title','meta_description','meta_keywords'],

                    fn () => $abortIfNull ? abort(404) : null,
                );

        if ($page)
            $page->append('props');

        return $page;
    }


}
