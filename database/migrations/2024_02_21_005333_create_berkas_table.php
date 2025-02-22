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
        Schema::create('berkas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nomor_berkas')->unique();
            $table->text('nama_berkas');
            $table->string('jenis');
            $table->date('tanggal');
            $table->string('nama_pengirim');
            $table->string('contact');
            $table->string('file_berkas')->nullable();
            // $table->string('nama_pengirim')->nullable();
            // $table->uuid('lembaga_id');
            // $table->uuid('wilayah_id');
            $table->uuid('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('berkas');
    }
};
