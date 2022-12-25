<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class ProductAttribute extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    public $perPage = 50;

    protected $fillable = [
        'type',
        'value',
        'extra',
    ];

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = Str::lower($value);
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = Str::lower($value);
    }

}
