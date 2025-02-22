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
        Schema::create('riwayat_baru', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('tindakan');
            $table->string('status');
            $table->string('peninjau')->nullable();
            $table->string('dokumentasi_sarpras')->nullable();
            $table->text('alasan')->nullable();
            $table->uuid('baru_id');
            $table->uuid('user_id');

            $table->timestamps();

            $table->foreign('baru_id')->references('id')->on('baru')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_baru');
    }
};
