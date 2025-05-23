<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;

class RiwayatPengaduanModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "riwayat_pengaduan";
    protected $fillable = [
        'status',
        'alasan',
        'pengaduan_id',
        'user_id',
        'peninjau',
        'tindakan'
    ];
    public function pengaduan(){
        return $this->belongsTo(PengaduanModel::class, 'pengaduan_id','id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
