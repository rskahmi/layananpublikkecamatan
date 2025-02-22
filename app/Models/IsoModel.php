<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;

class IsoModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "iso";
    protected $fillable = [
        'nama',
        'jenis',
        'tgl_aktif',
        'masa_berlaku',
        'tgl_berakhir',
        'status',
        'user_id'
    ];
}
