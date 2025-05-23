<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PengaduanModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = 'pengaduan';
    protected $fillable = [
        'deskripsi',
        'tanggal',
        'bukti',
        'status',
        'user_id'
    ];

    public function riwayat(){
        return $this->hasMany(RiwayatPengaduanModel::class, 'pengaduan_id','id');
    }
}
