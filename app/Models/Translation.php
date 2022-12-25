<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Translation extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    public $perPage = 50;

    protected $fillable = [
        'lang',
        'key',
        'value',
    ];


    public function setKeyAttribute($value)
    {
        $this->attributes['key'] = Str::lower($value);
    }
}
