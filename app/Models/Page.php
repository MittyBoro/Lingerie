<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends BaseModel
{
    use HasFactory;

    protected $perPage = 30;
    protected $guarded = ['props'];

    protected $orderFileds = [
        'id', 'title', 'created_at'
    ];

    protected $orderBy = ['created_at', 'asc'];

    public static function boot()
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

    // public function getPropsAttribute()
    // {
    //     return $this->properties->keyBy('key')
    //                             ->map(function($item) {
    //                                 return $item->value;
    //                             });
    // }

    public function scopeBySlug($query, $slug, $abortIfNull = true)
    {
        $page = $query
                ->where('slug', $slug)
                // ->where('is_hidden', true)
                ->with('properties')
                ->firstOr(
                    ['id','route','slug','title','description','meta_title','meta_description','meta_keywords'],
                    function() use ($abortIfNull) {
                        if ($abortIfNull)
                            return abort(404);
                        return null;
                    }
                );

        if ($page)
            $page->append('props');

        return $page;
    }


}
