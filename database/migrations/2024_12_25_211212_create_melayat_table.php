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
        Schema::create('melayat', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('status');
            $table->uuid('sij_id');
            $table->string('emailberitaduka')->nullable();

            $table->timestamps();
            $table->foreign('sij_id')->references('id')->on('sij')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('melayat');
    }
};
