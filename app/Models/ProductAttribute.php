<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class ProductAttribute extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    public $perPage = 50;

    protected $orderBy = ['position', 'asc'];

    protected $fillable = [
        'type',
        'value',
        'extra',
        'position',
    ];

    protected static function booted()
    {
        static::addGlobalScope('ordered', function ($builder) {
            $builder->orderBy('position');
        });
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = Str::lower($value);
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = Str::lower($value);
    }

}
