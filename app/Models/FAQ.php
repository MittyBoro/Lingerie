<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class FAQ extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'faqs';
}
