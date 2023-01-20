<?php

namespace App\Models;

use App\Models\Traits\RetrievingTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class ProductAttribute extends Model
{
    use HasFactory;
    use RetrievingTrait;

    public $timestamps = false;

    protected $sortable = ['position', 'type', 'value'];

    protected $fillable = [
        'type',
        'value',
        'extra',
        'position',
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
