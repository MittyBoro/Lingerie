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
		Schema::create('feedback_orders', function (Blueprint $table) {
			$table->id();

			$table->string('name')->nullable();
			$table->string('phone')->nullable();
			$table->string('email')->nullable();
			$table->string('city')->nullable();
			$table->text('comment')->nullable();

			$table->string('form');

			$table->string('user_hash', 32)->nullable();
			// ip + useragent

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
		Schema::dropIfExists('feedback_orders');
	}
};
