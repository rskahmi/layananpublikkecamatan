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
        Schema::create('kembalikan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->timestamps();
            $table->string('status');
            $table->uuid('rd_id');
            $table->string('suratpermohonankembalikan')->nullable();
            $table->foreign('rd_id')->references('id')->on('rd')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kembalikan');
    }
};
