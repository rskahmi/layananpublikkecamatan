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
        Schema::create('proposal', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->double('anggaran')->nullable();
            $table->string('status');
            $table->integer('total_waktu');
            $table->string('jenis');
            $table->uuid('lembaga_id');
            $table->uuid('wilayah_id');
            $table->uuid('berkas_id');
            $table->timestamps();

            $table->foreign('lembaga_id')->references('id')->on('lembaga');
            $table->foreign('wilayah_id')->references('id')->on('wilayah');
            $table->foreign('berkas_id')->references('id')->on('berkas')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal');
    }
};
