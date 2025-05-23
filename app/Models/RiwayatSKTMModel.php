<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;

class RiwayatSKTMModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "riwayat_sktm";
    protected $fillable = [
        'status',
        'alasan',
        'sktm_id',
        'user_id',
        'peninjau',
        'tindakan'
    ];
    public function sktm(){
        return $this->belongsTo(SKTMModel::class, 'sktm_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
