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
        Schema::create('watches', function (Blueprint $table) {
            $table->id('idWatch');
            $table->unsignedBigInteger('idBrend');
            $table->string('name');
            $table->unsignedBigInteger('idMech');
            $table->unsignedBigInteger('idGen');
            $table->unsignedBigInteger('idStyle');
            $table->text('discription');
            $table->double('price');
            $table->timestamps();

            $table->foreign('idBrend')->references('idBrend')->on('brends');
            $table->foreign('idMech')->references('idMechanism')->on('mechanisms');
            $table->foreign('idGen')->references('idGender')->on('genders');
            $table->foreign('idStyle')->references('idStyle')->on('styles');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('watches');
    }
};
