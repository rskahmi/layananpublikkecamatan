<?php

namespace App\Models;

use App\Traits\UuidTraits;
use App\Models\WilayahModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TjslModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "tjsl";
    protected $fillable = [
        'nama',
        'jenis',
        'anggaran',
        'pic',
        'contact',
        'tanggal',
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
    public function anggaran(): HasOne
    {
        return $this->hasOne(RiwayatAnggaranModel::class, 'id', 'tjsl_id');
    }
    public function dokumentasi(): HasMany
    {
        return $this->hasMany(DokumentasiTjslModel::class, 'tjsl_id', 'id');
    }
}
