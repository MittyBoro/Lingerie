<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class BaseModel extends Model
{
    protected $guarded = false;

    protected $perPage = 20;

    protected $defaultOrder = ['id', 'desc'];

    protected $orderFileds = [
        'created_at', 'id',
    ];

    // выкинуть ошиботьку
    public function throwArray($errors)
    {
        $messages = [];
        foreach ($errors as $k => $v)
        {
            $messages[$k] = [$v];
        }

        throw ValidationException::withMessages($messages);
    }

    // получить ключ/направление сортировки
    protected function getOrderBy()
    {
        if (request('orderby'))
        {
            $orderBy = explode(',', request('orderby'));
            if ( !in_array($orderBy[0], $this->orderFileds) )
                $orderBy = $this->defaultOrder;
        }
        else
        {
            $orderBy = $this->defaultOrder;
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

    public function scopeWeek($query)
    {
        $query->whereDate( 'created_at', '>=', Carbon::now()->subDays(7));
    }

    public function scopeMonth($query)
    {
        $query->whereDate( 'created_at', '>=', Carbon::now()->subDays(30));
    }

    public function scopeHalfYear($query)
    {
        $query->whereDate( 'created_at', '>=', Carbon::now()->subDays(183));
    }

    public function scopeYear($query)
    {
        $query->whereDate( 'created_at', '>=', Carbon::now()->subDays(365));
    }

    public function localize($value)
    {
        if ($value)
            return Carbon::parse($value, config('app.timezone'))->timezone(config('app.local_timezone'));
    }

    public function hasAttribute($key)
    {
        return array_key_exists($key, $this->attributes);
    }

}
