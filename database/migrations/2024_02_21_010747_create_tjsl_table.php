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
        Schema::create('tjsl', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('nama');
            $table->string('jenis');
            $table->double('anggaran');
            $table->string('pic');
            $table->string('contact');
            $table->date('tanggal');
            $table->uuid('lembaga_id');
            $table->uuid('wilayah_id');
            $table->uuid('user_id');
            $table->timestamps();
            $table->foreign('lembaga_id')->references('id')->on('lembaga');
            $table->foreign('wilayah_id')->references('id')->on('wilayah');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tjsl');
    }
};
