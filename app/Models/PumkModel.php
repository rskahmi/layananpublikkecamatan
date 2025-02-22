<?php

namespace App\Models;

use App\Traits\UuidTraits;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;


class PumkModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "pumk";
    protected $fillable = [
        'nama_usaha',
        'nama_pengusaha',
        'contact',
        'agunan',
        'anggaran',
        'tanggal',
        'jatuh_tempo',
        'status',
        'lembaga_id',
        'wilayah_id',
        'user_id'
    ];

    public function wilayah()
    {
        return $this->belongsTo(WilayahModel::class, 'wilayah_id');
    }
    public function lembaga()
    {
        return $this->belongsTo(LembagaModel::class, 'lembaga_id');
    }
}
