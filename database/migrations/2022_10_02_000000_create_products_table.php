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

			$table->string('slug')->unique();

			$table->boolean('is_published')->default(false);

			// $table->boolean('is_stock')->default(true);
			$table->decimal('price')->default(0);

            // ru
			$table->string('title_ru')->nullable();
			$table->string('meta_title_ru')->nullable();
			$table->string('meta_description_ru')->nullable();
			$table->string('meta_keywords_ru')->nullable();
            // en
            $table->string('title_en')->nullable();
			$table->string('meta_title_en')->nullable();
			$table->string('meta_description_en')->nullable();
			$table->string('meta_keywords_en')->nullable();




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
