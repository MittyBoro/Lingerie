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
		Schema::create('posts', function (Blueprint $table) {
			$table->id();

			$table->foreignId('user_id')->constrained()->cascadeOnDelete();

			$table->string('title');
			$table->string('slug')->index()->unique();
			$table->boolean('is_published')->index()->default(false);

			$table->text('description')->nullable();

			$table->string('meta_title')->nullable();
			$table->string('meta_description')->nullable();
			$table->string('meta_keywords')->nullable();

			$table->foreignId('partner_id')->nullable()->constrained()->nullOnDelete();

			$table->timestamp('published_at')->useCurrent()->nullable();
			$table->timestamps();

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
		Schema::dropIfExists('posts');
	}
};
