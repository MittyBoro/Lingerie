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
        /*
        ==цвет, размер
        product_attribute_type
            id
            name
        ==синий, зелёный, S, M, L
        product_attribute_values
            id
            product_attribute_type_id
            name
        ==зелёный S 500₽
        product_variants
            id
            product_id
            title??
            price
        product_variant_product_attribute_value
            product_attribute_value_id
            product_variant_id
        */

        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->index()->constrained()->cascadeOnDelete();

            $table->string('title')->nullable();
            $table->string('price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_variants');
    }
};
