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
        Schema::create('profil_perusahaan', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->text('gambar')->nullable();
            $table->string('jenis');
            $table->string('kategori')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('jabatan')->nullable();
            $table->integer('tingkatan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile_ru_i_i');
    }
};
