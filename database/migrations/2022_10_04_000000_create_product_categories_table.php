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

            $table->string('slug');
            $table->string('lang')->default('ru');

            // ru
            $table->string('title_ru');
            $table->text('description_ru')->nullable();
            $table->string('meta_title_ru')->nullable();
            $table->string('meta_description_ru')->nullable();
            $table->string('meta_keywords_ru')->nullable();
            // en
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();


            $table->integer('position')->default(0);

            $table->nestedSet();
            $table->unique('slug', 'lang');
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
