<?php

namespace App\Models;
use App\Traits\UuidTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KKModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "kk";
    protected $fillable = [
        'status',
        'surat_id',
        'ktp_kk',
        'suratkelurahan_kk'
    ];
    public function surat(){
        return $this->belongsTo(SuratModel::class, 'surat_id','id');
    }
    public function riwayat(){
        return $this->hasMany(RiwayatKKModel::class, 'kk_id','id');
    }
}
