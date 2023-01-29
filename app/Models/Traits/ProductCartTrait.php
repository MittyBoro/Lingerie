<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

trait ProductCartTrait
{

    public function scopeFindForCart(Builder $query, $id, $lang)
    {
        $prod = $query
                ->with(['options', 'media'])
                ->isPublished()
                ->localized($lang)
                ->findOrFail($id);

        $prod->append('preview');
        $prod->makeHidden('options');

        return $prod;
    }

    public function getOptionsWords($ids)
    {
        $options = $this->options->whereIn('id', $ids)->values();

        if ($options->count() != count($ids)) {
            abort(412);
        }

        return $options->map(function($value) {
                    return [
                        'id' => $value->id,
                        'type' => $value->type,
                        'value' => $value->value,
                    ];
                });
    }

    public function getCartId($options)
    {
        return $this->id . '__'. implode('_', Arr::sort($options));
    }

    public function getIsAvailableAttribute()
    {
        return $this->is_stock && $this->is_published;
    }
}
