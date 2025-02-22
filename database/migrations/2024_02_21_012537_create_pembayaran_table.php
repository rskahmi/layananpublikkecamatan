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
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->double('jumlah_pembayaran');
            $table->date('tanggal');
            $table->double('sisa_pembayaran');
            $table->uuid('pumk_id');
            $table->uuid('user_id');
            $table->timestamps();

            $table->foreign('pumk_id')->references('id')->on('pumk')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
