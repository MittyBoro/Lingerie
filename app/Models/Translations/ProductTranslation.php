<?php

namespace App\Models\Translations;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class ProductTranslation extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'slug',
        'lang',
        'title',
        'price',

        'texts',

        'meta_title',
        'meta_description',
        'meta_keywords',
        'position',
    ];

    protected $casts = [
        'texts'   => 'array',
        'is_stock'     => 'bool',
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
