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
		Schema::create('pages', function (Blueprint $table) {
			$table->id();

			$table->string('slug')->index()->unique();
			$table->boolean('is_hidden')->index()->default(false);
			$table->string('route')->nullable();

            // ru
			$table->string('title_ru')->nullable();
			$table->text('description_ru')->nullable();
			$table->string('meta_title_ru')->nullable();
			$table->string('meta_description_ru')->nullable();
			$table->string('meta_keywords_ru')->nullable();
            // en
			$table->string('title_en')->nullable();
			$table->text('description_en')->nullable();
			$table->string('meta_title_en')->nullable();
			$table->string('meta_description_en')->nullable();
			$table->string('meta_keywords_en')->nullable();

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
		Schema::dropIfExists('pages');
	}
};
