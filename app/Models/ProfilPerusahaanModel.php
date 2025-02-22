<?php

namespace App\Models;

use App\Traits\UuidTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilPerusahaanModel extends Model
{
    use HasFactory, UuidTraits;

    protected $table = "profil_perusahaan";
    public $fillable = [
        'gambar',
        'jenis',
        'kategori',
        'deskripsi',
        'jabatan'
    ];
}
