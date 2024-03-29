<?php

use App\Models\Order;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('uuid', 40)->unique()->index();
            $table->string('cart_id')->nullable();

            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();

            $table->string('payment_type')->nullable();
            $table->json('payment_data')->nullable();

            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->json('address')->nullable();
            $table->text('comment')->nullable();

            $table->decimal('amount', 10, 2)->unsigned();
            $table->string('currency', 10);
            $table->string('lang', 4);

            $table->string('status', 16)->default(Order::STATUS_PENDING);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
