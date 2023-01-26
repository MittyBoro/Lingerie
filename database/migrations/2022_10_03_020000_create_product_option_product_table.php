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
        Schema::create('product_product_option', function (Blueprint $table) {
            $table->foreignId('product_id')
                  ->index()
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('product_option_id')
                  ->index()
                  ->constrained()
                  ->cascadeOnDelete();

            $table->unique(['product_id', 'product_option_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_product_option');
    }
};
