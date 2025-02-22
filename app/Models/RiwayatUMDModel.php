<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;


class RiwayatUMDModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table="riwayat_umd";
    protected $fillable = [
        'status',
        'alasan',
        'umd_id',
        // 'status_verifikasi',
        'user_id',
        'peninjau',
        'tindakan'
    ];
    public function umd(){
        return $this->belongsTo(UMDModel::class, 'umd_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
