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
        Schema::create('spd', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->date('tanggal');
            $table->date('tanggalberangkat');
            $table->date('tanggalpulang');
            $table->string('tujuan');
            $table->string('status');
            $table->string('lampiran')->nullable();
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spd');
    }
};
