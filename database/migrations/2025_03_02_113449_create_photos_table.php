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
        Schema::create('photos', function (Blueprint $table) {
            $table->id('idPhoto');
            $table->unsignedBigInteger('idWatch');
            $table->string('photo')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();

            $table->foreign('idWatch')->references('idWatch')->on('watches');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('photos');
    }
};
