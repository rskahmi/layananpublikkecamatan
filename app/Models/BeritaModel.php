<?php

namespace App\Models;

use App\Traits\UuidTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BeritaModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "berita";
    protected $fillable = [
        'judul',
        'deskripsi',
        'foto',
    ];
}
