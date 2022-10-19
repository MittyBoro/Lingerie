<?php

use App\Models\Prop;
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
		Schema::create('props', function (Blueprint $table) {
			$table->id();

			$table->string('tab')->nullable()->default(Prop::DEFAULT_TAB);
			$table->nullableMorphs('model');

			$table->string('type');
			$table->string('key')->index();
			$table->string('title')->nullable();

			$table->string('value_string')->nullable();
			$table->text('value_text')->nullable();

			$table->integer('position')->default(0);

			$table->unique(['key', 'model_id', 'model_type']);
			$table->index(['model_id', 'model_type'], 'key');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('props');
	}
};
