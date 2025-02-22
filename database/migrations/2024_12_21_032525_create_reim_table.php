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
        Schema::create('reim', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('status');
            $table->uuid('npp_id');
            $table->string('berkasnpp')->nullable();
            $table->string('nota')->nullable();
            $table->string('kwitansi')->nullable();
            $table->string('dokumenpersetujuan')->nullable();





            $table->timestamps();

            $table->foreign('npp_id')->references('id')->on('npp')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reim');
    }
};
