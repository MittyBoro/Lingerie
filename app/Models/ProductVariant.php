<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends BaseModel
{
	use HasFactory;

	public $timestamps = false;

	protected $defaultOrder = ['position', 'asc'];
}
