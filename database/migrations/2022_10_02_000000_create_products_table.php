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

            $table->boolean('is_published')->default(false);
            $table->boolean('is_stock')->default(true);

            $table->integer('position')->default(0);
            $table->string('slug')->index()->unique();

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
        Schema::dropIfExists('products');
    }
};
