<?php

namespace App\Models\Translations;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class ProductTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'lang',
        'title',
        'price',

        'details',

        'meta_title',
        'meta_description',
        'meta_keywords',
        'position',
    ];

    protected $casts = [
        'details'  => 'array',
    ];

    public function setMetaTitleAttribute($val)
    {
        $this->attributes['meta_title'] = empty($val) ? $this->attributes['title'] : $val;
    }

    public function setSlugAttribute($val)
    {
        $this->attributes['slug'] = Str::slug($val);
    }
}
