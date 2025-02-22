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
        Schema::create('riwayat_anggaran', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('tujuan');
            $table->date('tanggal');
            $table->double('nominal');
            $table->double('sisa_anggaran');
            $table->uuid('tjsl_id');
            $table->uuid('user_id');
            $table->timestamps();

            $table->foreign('tjsl_id')->references('id')->on('tjsl')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_anggaran');
    }
};
