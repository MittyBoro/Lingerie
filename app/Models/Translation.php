<?php

namespace App\Models;

use App\Models\Traits\RetrievingTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Translation extends Model
{
    use HasFactory;
    use RetrievingTrait;

    public $timestamps = false;

    protected $fillable = [
        'lang',
        'key',
        'value',
    ];

    protected $sortable = [
        'key', 'value', 'lang',
    ];


    public function setKeyAttribute($value)
    {
        $this->attributes['key'] = Str::snake($value);
    }
}
