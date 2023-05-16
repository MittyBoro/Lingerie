<?php

namespace App\Models;

use App\Models\Traits\RetrievingTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FAQ extends Model
{
    use HasFactory;
    use RetrievingTrait;


    public $timestamps = false;

    protected $table = 'faqs';

    protected $fillable = [
        'lang',
        'title',
        'description',
        'position',
    ];

    protected $sortable = ['position', 'title', 'lang'];


    public function scopeGetFrontList($query, $lang)
    {
        $result = $query
                    ->select('title', 'description')
                    ->orderBy('position')
                    ->whereLang($lang)
                    ->get();

        return $result;
    }
}
