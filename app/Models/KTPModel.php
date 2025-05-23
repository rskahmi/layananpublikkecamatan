<?php

namespace App\Models;

use App\Traits\UuidTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KTPModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "ktp";
    protected $fillable = [
        'status',
        'surat_id',
        'kk_ktp',
        'suratkelurahan_ktp'
    ];

    public function surat(){
        return $this->belongsTo(SuratModel::class, 'surat_id','id');
    }
    public function riwayat(){
        return $this->hasMany(RiwayatKTPModel::class, 'ktp_id','id');
    }
}
