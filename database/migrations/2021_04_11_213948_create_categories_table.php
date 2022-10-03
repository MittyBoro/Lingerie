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
		Schema::create('categories', function (Blueprint $table) {
			$table->id();

			$table->string('model_type');

			$table->string('slug')->unique();
			$table->string('title');
			$table->text('description')->nullable();
			$table->text('footer_description')->nullable();

			$table->string('meta_title')->nullable();
			$table->string('meta_description')->nullable();
			$table->string('meta_keywords')->nullable();

			$table->integer('position')->default(0);

			$table->nestedSet();

			$table->unique(['slug', 'model_type']);
		});

	}



	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('categories');
	}
};
