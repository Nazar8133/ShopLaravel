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
        Schema::create('buyers', function (Blueprint $table) {
            $table->id('idBuyer');
            $table->string('googleId')->nullable()->unique();
            $table->string('pib')->nullable();
            $table->string('number')->nullable()->unique();
            $table->string('email')->unique();
            $table->unsignedBigInteger('idAddress')->nullable();
            $table->unsignedBigInteger('idNovaPost')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('idAddress')->references('idAddress')->on('addresses');
            $table->foreign('idNovaPost')->references('idNovaPost')->on('nova_post_addresses');
        });

        Schema::create('buyers_password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('buyers');
        Schema::dropIfExists('buyers_password_reset_tokens');
    }
};
