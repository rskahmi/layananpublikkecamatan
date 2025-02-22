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
        Schema::create('program_unggulan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_program');
            $table->string('nama_kelompok');
            $table->string('mitra_binaan');
            $table->string('ketua_kelompok');
            $table->string('contact');
            $table->string('pic');
            $table->text('deskripsi');
            $table->string('gambar');
            $table->uuid('wilayah_id');
            $table->uuid('user_id');
            $table->timestamps();

            $table->foreign('wilayah_id')->references('id')->on('wilayah');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_unggulan');
    }
};
