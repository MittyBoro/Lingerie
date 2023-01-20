<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait RetrievingTrait
{

    public function scopeWhereLang(Builder $query, $lang)
    {
        if ($lang)
            $query->where('lang', $lang);
    }

    public function scopeCustomOrder(Builder $query, $column = 'id', $direction = 'asc')
    {
        $sortableColumns = $this->sortable ?: ['id'];

        $query->orderBy(
            in_array($column, $sortableColumns) ? $column : $sortableColumns[0],
            $direction == 'asc' ? 'asc' : 'desc'
        );
    }

    public function scopeCustomPaginate($query, $perPage = null, $append = null)
    {
        $paginated = $query->paginate( $perPage );

        $result = $paginated
                        ->withQueryString()
                        ->setPath('')
                        ->onEachSide(1);

        if ($append) {
            $result->through( fn ($item) => $item->append($append) );
        }

        return $result;
    }

}
