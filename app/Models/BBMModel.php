<?php

namespace App\Models;
use App\Traits\UuidTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BBMModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = 'bbm';
    protected $fillable = [
        'status',
        'surat_id',
        'ktp_bbm',
        'nimb_bbm'
    ];

    public function surat(){
        return $this->belongsTo(BBMModel::class, 'surat_id', 'id');
    }
    public function riwayat(){
        return $this->hasMany(RiwayatBBMModel::class, 'bbm_id', 'id');
    }
}

