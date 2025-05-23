<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;

class RiwayatKTPModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "riwayat_ktp";
    protected $fillable = [
        'status',
        'alasan',
        'ktp_id',
        'user_id',
        'peninjau',
        'tindakan'
    ];
    public function ktp(){
        return $this->belongsTo(KTPModel::class, 'ktp_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
