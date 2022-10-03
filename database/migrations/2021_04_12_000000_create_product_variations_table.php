<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_variations', function (Blueprint $table) {
			$table->id();

			$table->foreignId('product_id')->index()->constrained()->cascadeOnDelete();

			$table->string('name')->nullable();
			$table->string('value')->nullable();
			$table->string('vendor_code')->nullable();
			$table->decimal('price')->default(0);
			$table->integer('position')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('product_variations');
	}
};
