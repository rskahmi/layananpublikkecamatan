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
        Schema::create('iso', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('nama');
            $table->text('jenis');
            $table->date('tgl_aktif');
            $table->integer('masa_berlaku');
            $table->date('tgl_berakhir');
            $table->string('status');
            $table->uuid('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('iso');
    }
};
