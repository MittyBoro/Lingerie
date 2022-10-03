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
		Schema::create('product_order_items', function (Blueprint $table) {
			$table->id();

			$table->foreignId('order_id')->index()->constrained('product_orders')->cascadeOnDelete();
			$table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();

			$table->string('name');
			$table->decimal('price')->unsigned();
			$table->decimal('discount_price')->unsigned();
			$table->tinyInteger('quantity')->unsigned()->default(1);
			$table->json('variations')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('product_order_items');
	}
};
