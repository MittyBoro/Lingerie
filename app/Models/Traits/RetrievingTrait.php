<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait RetrievingTrait
{

    public function scopeCustomOrder(Builder $query, $orderBy = [])
    {
        $column = $orderBy[0];
        $direction = $orderBy[1] ?? 'asc';

        $sortableColumns = $this->sortable ?: ['id'];

        $column = in_array($column, $sortableColumns) ? $column : $sortableColumns[0];
        $direction = $direction == 'asc' ? 'asc' : 'desc';

        $query->orderBy($column, $direction);
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
