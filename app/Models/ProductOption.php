<?php

namespace App\Models;

use App\Models\Traits\RetrievingTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class ProductOption extends Model
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

    protected $hidden = ['pivot'];


    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function setTypeAttribute($value)
    {
        $this->attributes['type'] = Str::lower($value);
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = Str::lower($value);
    }

    public function scopeGetPublic($query, $categoryId = null)
    {
        $result = $query
                        ->whereHas('products', function($prodQ) use ($categoryId) {
                            $prodQ->isPublished();
                            $prodQ->relationByIds('categories', $categoryId);
                        })
                        ->orderBy('position')
                        ->get(['id', 'type', 'value', 'extra'])
                        ->groupBy('type')
                        ;

        return $result;
    }

}
