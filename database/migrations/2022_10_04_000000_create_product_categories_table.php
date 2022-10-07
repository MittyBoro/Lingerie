<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\ProdCategory;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('product_categories', function (Blueprint $table) {
			$table->id();

			$table->string('slug')->unique();

            // ru
			$table->string('title_ru');
			$table->text('description_ru')->nullable();
			$table->string('meta_title_ru')->nullable();
			$table->string('meta_description_ru')->nullable();
			$table->string('meta_keywords_ru')->nullable();
            // en
			$table->string('title_en');
			$table->text('description_en')->nullable();
			$table->string('meta_title_en')->nullable();
			$table->string('meta_description_en')->nullable();
			$table->string('meta_keywords_en')->nullable();


			$table->integer('position')->default(0);

			$table->nestedSet();
		});

	}



	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('product_categories');
	}
};
