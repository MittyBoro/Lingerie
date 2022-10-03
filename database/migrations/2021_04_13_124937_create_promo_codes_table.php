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
		Schema::create('promo_codes', function (Blueprint $table) {
			$table->id();

			$table->string('code')->unique();
			$table->decimal('percent')->default(0);
			$table->bigInteger('count')->default(0);

			$table->boolean('is_active')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('promo_codes');
	}
};
