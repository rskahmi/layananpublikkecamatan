<?php

namespace App\Models;

use App\Traits\UuidTraits;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengumumanModel extends Model
{
   use HasFactory, UuidTraits;
    protected $table = "pengumuman";
    protected $fillable = [
        'judul',
        'deskripsi',
        'foto',
    ];
}
