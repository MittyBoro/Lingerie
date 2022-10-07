<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

use Kalnoy\Nestedset\NodeTrait;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductCategory extends BaseModel
{
	use HasFactory;
	use NodeTrait;


	public $timestamps = false;

	protected $defaultOrder = ['position', 'asc'];

	protected $orderFileds = [
		'position'
	];

	protected $hidden = ['_lft', '_rgt', 'position'];

    protected $languageFieds = [
        'title',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];


	public static function boot()
	{
		parent::boot();

		static::creating( function($model)
		{
			$model->position = self::max('position') + 1;
		});

		static::saving( function($query)
		{
			if ( empty($query->meta_title) )
				$query->meta_title = $query->title;
		});

		static::updated( function($model)
		{
			static::fixTree();
		});
	}

    protected static function booted()
    {
        static::addGlobalScope('ordered', function ($builder) {
            $builder->ordered();
        });
    }

	public function models()
	{
		return $this->belongsToMany($this->model_type, 'category_model', 'category_id', 'model_id', );
	}

	public function getTypeAttribute()
	{
		return Str::snake(Str::pluralStudly(class_basename($this->model_type)));
	}

	public function setSlugAttribute($val)
	{
		$this->attributes['slug'] = Str::slug($val);
	}

	public function scopeGet4Admin($query, $model)
	{
		$list = $query
				->onlyModel($model)
				->ordered()
				->withDepth()
				->get()
				->toFlatTree();

		return $list;
	}

	public function scopeGetAllCategories($query, $model)
	{
		return $query
				->onlyModel($model)
				->orderBy('position')
				->withCount(['models' => function ($query) {
					$query->where('is_published', true);
					// $query->where('is_stock', true);
				}])
				->withDepth()
				->get()
				->toFlatTree()
				->where('models_count', '>', 0)
				->values();
	}

	public function scopeOnlyModel($query, $model)
	{
		$this->model_type = $model;
		return $query->where('model_type', $model);
	}

	public function scopeIsUnique($query)
	{
		$hasRow = self::whereNot('id', $this->id)
						->where('model_type', $this->model_type)
						->where('slug', $this->slug);

		return $hasRow;
	}

	public function scopeGetTree($query, $model)
	{
		$data = $query
					->onlyModel($model)
					->select('id', 'title', 'slug', 'position', '_lft', '_rgt', 'parent_id')
					->withCount('models')
					->get()
					->toTree();
		return $data;
	}

	public function updateTree($items)
	{
		try {
			collect($items)->each(function($item, $key) {
				$item = Arr::only($item, ['id', 'parent_id']);
				$item['position'] = $key;

				static::where('id', $item['id'])->update($item);
			});

			static::fixTree();

		} catch (\Throwable $e) {
			return false;
		}

		return true;
	}

}
