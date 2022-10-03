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
		Schema::create('products', function (Blueprint $table) {
			$table->id();

			$table->foreignId('user_id')->constrained()->cascadeOnDelete();

			$table->string('title');
			$table->string('slug')->unique();

			$table->boolean('is_published')->default(false);
			$table->boolean('is_stock')->default(true);

			$table->bigInteger('count')->default(0);

			$table->text('short_description')->nullable();
			$table->text('description')->nullable();

			$table->json('characteristics')->nullable();

			$table->string('meta_title')->nullable();
			$table->string('meta_description')->nullable();
			$table->string('meta_keywords')->nullable();

			$table->integer('position')->default(0);

			$table->timestamps();

			$table->index(['slug', 'is_published']);

			$table->softDeletes();
		});
	}

	/**
		* Reverse the migrations.
		*
		* @return void
		*/
	public function down()
	{
		Schema::dropIfExists('products');
	}
};
