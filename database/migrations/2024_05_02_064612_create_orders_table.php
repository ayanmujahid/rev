<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */


    public function up(): void
    {
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->string('order_id')->unique();
                $table->unsignedBigInteger('user_id');
                $table->foreign('user_id')->references('id')->on('users');
                $table->unsignedBigInteger('shipping_address_id');
                $table->foreign('shipping_address_id')->references('id')->on('shipping_addresses');
                $table->decimal('subtotal', 10, 2);
                $table->decimal('shipping_cost', 10, 2);
                $table->decimal('total', 10, 2);
                $table->string('affiliate_link');
                $table->string('payment_status')->default('pending');
                $table->string('payment_intent');
                $table->string('record_id');
                $table->string('printify_order_id');
                $table->string('resp_data');
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
