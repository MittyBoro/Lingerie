<?php

namespace App\Models;

use App\Models\Translations\ProductCategoryTranslation;
use Kalnoy\Nestedset\NodeTrait;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends BaseModel
{
    use HasFactory;
    use NodeTrait;


    public $timestamps = false;

    protected $hidden = ['_lft', '_rgt'];

    protected $fillable = [
        'parent_id', // мб пофиксить
        'position',
        '_lft',
        '_rgt'
    ];

    protected static function booted()
    {
        static::addGlobalScope('ordered', function ($builder) {
            $builder->orderBy('position');
        });
    }

    public function translations()
    {
        return $this->hasMany(ProductCategoryTranslation::class, 'category_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function scopeGetAllCategories($query)
    {
        return $query
                ->withDepth()
                ->get()
                ->toFlatTree()
                // ->where('models_count', '>', 0)
                ->values();
    }

    public function scopeGetTree($query)
    {
        $data = $query
                    ->select('id', 'position', '_lft', '_rgt', 'parent_id')
                    ->withCount('products')
                    ->get()
                    ->toTree();
        return $data;
    }

}
