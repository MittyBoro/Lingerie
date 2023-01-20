<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class BaseModel extends Model
{
    protected $guarded = false;

    protected $perPage = 20;

    protected $orderBy = ['id', 'desc'];

    protected $orderFileds = [
        'created_at', 'id',
    ];

    // получить ключ/направление сортировки
    protected function getOrderBy()
    {
        if (request('orderby'))
        {
            $orderBy = explode(',', request('orderby'));
            if ( !in_array($orderBy[0], $this->orderFileds) )
                $orderBy = $this->orderBy;
        }
        else
        {
            $orderBy = $this->orderBy;
        }

        return $orderBy;
    }

    protected function perPage(): int
    {
        $perPage = request('count') ?: request('perPage', $this->perPage);

        if ($perPage < 1) $perPage = $this->perPage;

        return $perPage;
    }


    public function scopePaginated($query, $append = null)
    {
        $result = $query->ordered()
                        ->paginate( $this->perPage() )
                        ->withQueryString()
                        ->setPath('')
                        ->onEachSide(1);

        if ($append) {
            $result->through(function ($item) use ($append) {
                return $item->append($append);
            });
        }

        return $result;
    }

    public function scopeSetPerPage($query, $perPage)
    {
        $this->perPage = $perPage;
    }

    public function scopeOrdered($query)
    {
        $orderBy = $this->getOrderBy();
        $query->orderBy( $orderBy[0], $orderBy[1] ?? 'asc' );
    }

    public function scopeGetOrdered($query)
    {
        return $query->ordered()->get();
    }

    public function massUpdate($data)
    {
        DB::transaction(function() use ($data) {
            foreach($data as $v) {
                static::where('id', $v['id'])->update($v);
            }
        });
    }

    public function scopeExclude($query, $value = [])
    {
        return $query->select(array_diff($this->columns, (array) $value));
    }

    public function scopeByLang($query, $lang)
    {
        if ($lang)
            $query->whereLang( $lang );
    }

    public function hasAttribute($key)
    {
        return array_key_exists($key, $this->attributes);
    }

}
