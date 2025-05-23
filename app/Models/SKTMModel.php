<?php

namespace App\Models;
use App\Traits\UuidTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SKTMModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "sktm";
    protected $fillable = [
        'status',
        'surat_id',
        'ktm_sktm',
        'suratkelurahan_sktm'
    ];
    public function surat(){
        return $this->belongsTo(SuratModel::class, 'surat_id','id');
    }
    public function riwayat(){
        return $this->hasMany(RiwayatSKTMModel::class, 'sktm_id','id');
    }
}
