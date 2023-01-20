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

    protected $orderBy = ['position', 'asc'];

}
