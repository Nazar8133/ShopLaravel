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
        Schema::create('orders', function (Blueprint $table) {
            $table->id('idOrder');
            $table->string('numberOrder')->unique();
            $table->unsignedBigInteger('idBuyer');
            $table->text('watches');
            $table->string('delivery');
            $table->unsignedBigInteger('idPayment')->nullable();
            $table->string('payment');
            $table->string('paymentStatus')->nullable();
            $table->text('koment')->nullable();
            $table->unsignedBigInteger('idPromoCode')->nullable();
            $table->string('orderStatus');
            $table->timestamps();

            $table->foreign('idBuyer')->references('idBuyer')->on('buyers');
            $table->foreign('idPromoCode')->references('idPromoCode')->on('promo_codes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
