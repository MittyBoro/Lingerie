<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductAttributeType extends BaseModel
{
	use HasFactory;

	public $timestamps = false;

    protected $languageFieds = [
        'name',
    ];


}
