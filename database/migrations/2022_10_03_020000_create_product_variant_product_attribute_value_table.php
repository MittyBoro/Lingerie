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
        Schema::create('product_variant_product_attribute_value', function (Blueprint $table) {
            $table->foreignId('product_attribute_value_id')->index()
                                        ->constrained()->cascadeOnDelete();
            $table->foreignId('product_variant_id')->index()->constrained()->cascadeOnDelete();

            $table->unique(['product_attribute_value_id', 'product_variant_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variant_product_attribute_value');
    }
};
