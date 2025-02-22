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
        Schema::create('pemberitaan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('jenis');
            $table->text('tautan')->nullable();
            $table->string('respon');
            $table->text('gambar')->nullable();;
            $table->uuid('rilis_id');
            $table->timestamps();

            $table->foreign('rilis_id')->references('id')->on('rilis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemberitaan');
    }
};
