<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;

class RiwayatKKModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "riwayat_kk";
    protected $fillable = [
        'status',
        'alasan',
        'kk_id',
        'user_id',
        'peninjau',
        'tindakan'
    ];
    public function kk(){
        return $this->belongsTo(KKModel::class, 'kk_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
