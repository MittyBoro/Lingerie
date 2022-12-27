<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class ProductCategoryTranslation extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'lang',
        'title',
        'slug',

        'description',

        'meta_title',
        'meta_description',
        'meta_keywords',
    ];


    public function setMetaTitleAttribute($val)
    {
        if ( empty($this->attributes['meta_title']) )
            $this->attributes['meta_title'] = $this->attributes['title'];
    }

    public function setSlugAttribute($val)
    {
        $this->attributes['slug'] = Str::slug($val);
    }
}
