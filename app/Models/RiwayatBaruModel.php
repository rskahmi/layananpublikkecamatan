<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;

class RiwayatBaruModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "riwayat_baru";
    protected $fillable = [
        'status',
        'alasan',
        'dokumentasi_sarpras',
        'baru_id',
        'user_id',
        'peninjau',
        'tindakan'
    ];
    public function baru(){
        return $this->belongsTo(BaruModel::class, 'baru_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
