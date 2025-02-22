<?php

namespace App\Models;

use App\Traits\UuidTraits;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class DokumentasiPumkModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "dokumentasi_pumk";
    protected $fillable = [
        'nama_kegiatan',
        'tanggal',
        'nama_file',
        'pumk_id',
        'user_id'
    ]; 
}
