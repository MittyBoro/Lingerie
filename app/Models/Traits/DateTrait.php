<?php

namespace App\Models\Traits;

use Illuminate\Support\Carbon;

trait DateTrait
{
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

}
