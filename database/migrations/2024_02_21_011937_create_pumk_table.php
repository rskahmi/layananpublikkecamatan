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
        Schema::create('pumk', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('nama_usaha');
            $table->text('nama_pengusaha');
            $table->string('contact');
            $table->string('agunan');
            $table->double('anggaran')->default(0);
            $table->date('tanggal');
            $table->date('jatuh_tempo');
            $table->string('status');
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
        Schema::dropIfExists('pumk');
    }
};
