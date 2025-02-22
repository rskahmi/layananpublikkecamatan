<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;

class RiwayatRotasiModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table="riwayat_rotasi";
    protected $fillable = [
        'status',
        'alasan',
        'rotasi_id',
        'user_id',
        'peninjau',
        'tindakan'
    ];
    public function rotasi(){
        return $this->belongsTo(RotasiModel::class, 'rotasi_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
