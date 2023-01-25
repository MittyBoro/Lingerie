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

    public function scopeOrderByStr(Builder $query, $sort = 'id-desc')
    {
        $sort = empty($column) ? ($this->defaultSort ?: $sort) : $sort;

        [$column, $direction] = array_pad(explode('-', $sort, 2), 2, 'asc');

        $sortableColumns = $this->sortable ?: ['id'];

        $query->orderBy(
            in_array($column, $sortableColumns) ? $column : $sortableColumns[0],
            $direction
        );
    }

    public function scopeCustomPaginate($query, $perPage = null, $append = null)
    {
        $paginated = $query->paginate( $perPage, ['*'], 'p' );

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
