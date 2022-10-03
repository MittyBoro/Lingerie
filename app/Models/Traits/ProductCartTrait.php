<?php

namespace App\Models\Traits;


trait ProductCartTrait
{

	public function scopeFind4Cart($query, $id)
	{
		$query->select( 'id', 'slug', 'title', 'is_stock', 'is_published' )
				->with(['variations']);

		return $query->find($id);
	}

	public function scopeSet4Cart()
	{
		$this->attributes['preview'] = (clone $this)->preview;
		$this->offsetUnset('filtred_variations');
		return $this->withoutRelations();
	}

	public function getCartPriceAttribute()
	{
		return $this->filtred_variations->sum('price');
	}

	public function getIsAvailableAttribute()
	{
		return $this->is_stock && $this->is_published;
	}
}
