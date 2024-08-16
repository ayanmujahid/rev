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
        Schema::create('tracking_affiliations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->constrained()->cascadeOnDelete();
            // $table->string('user_email')->nullable();
            $table->bigInteger('parent_id')->nullable();
            // $table->string('parent_user_email')->nullable();
            $table->string('affiliated_code')->nullable();
            $table->enum('buy_status', [0, 1])->default(0)->nullable()->comment('0:not-buy; 1:buy');
            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('distribut_amount', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_affiliations');
    }
};
