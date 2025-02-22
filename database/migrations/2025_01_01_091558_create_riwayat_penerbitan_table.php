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
        Schema::create('riwayat_penerbitan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->boolean('tindakan');
            $table->string('status');
            $table->string('peninjau')->nullable();
            $table->text('alasan')->nullable();
            $table->uuid('penerbitan_id');
            $table->uuid('user_id');
            $table->timestamps();
            $table->foreign('penerbitan_id')->references('id')->on('penerbitan')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_penerbitan');
    }
};
