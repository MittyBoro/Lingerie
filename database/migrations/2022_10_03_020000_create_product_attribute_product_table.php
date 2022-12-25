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
        Schema::create('product_attribute_product', function (Blueprint $table) {
            $table->foreignId('product_id')
                  ->index()
                  ->constrained()
                  ->cascadeOnDelete();

            $table->foreignId('product_attribute_id')
                  ->index()
                  ->constrained()
                  ->cascadeOnDelete();

            $table->unique(['product_id', 'product_attribute_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_attribute_product');
    }
};
