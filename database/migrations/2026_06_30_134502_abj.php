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
        //
         Schema::create('abj', function (Blueprint $table){
            $table->id();
            $table->string('name_kepala_keluarga');

            // penampungan berjentik dan tidak
            $table->string('penampungan_berjentik');
            $table->string('penampungan_tidak_berjentik');

            // rumah berjentik dan tidak
            $table->string('rumah_berjentik');
            $table->string('rumah_tidak_berjentik');

            $table->unsignedBigInteger('id_kelurahan')->nullabel();
            $table->unsignedBigInteger('id_rt')->nullable();

            $table->foreign('id_kelurahan')->references('id')->on('kelurahan');
            $table->foreign('id_rt')->references('id')->on('rt');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::drop('abj');
    }
};
