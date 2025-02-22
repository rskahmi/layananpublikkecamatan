<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;

class DokumentasiTjslModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "dokumentasi_tjsl";
    protected $fillable = [
        'nama_kegiatan',
        'tanggal',
        'nama_file',
        'tjsl_id',
        'user_id'
    ];
}
