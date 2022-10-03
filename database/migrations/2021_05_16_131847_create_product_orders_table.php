<?php

use App\Models\Product\ProductOrder;
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
		Schema::create('product_orders', function (Blueprint $table) {
			$table->id();

			$table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

			$table->string('payment_type')->nullable();
			$table->string('payment_id')->nullable();
            $table->json('payment_data')->nullable();

			$table->string('name')->nullable();
			$table->string('phone')->nullable();
			$table->string('email')->nullable();
			$table->json('address')->nullable();
			$table->text('comment')->nullable();

			$table->decimal('delivery', 10, 2)->unsigned();
			$table->decimal('amount', 10, 2)->unsigned();
			$table->string('promocode')->nullable();

			$table->string('status', 16)->default(ProductOrder::STATUS_PENDING);
            $table->string('url', 4096)->nullable();

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('product_orders');
	}
};
