<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductProperty extends BaseModel
{
    use HasFactory;

    public $timestamps = false;

    protected $languageFieds = [
        'title',
        'description',
    ];


}
