<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;

class RiwayatMutasiModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table="riwayat_mutasi";
    protected $fillable = [
        'status',
        'alasan',
        'mutasi_id',
        'user_id',
        'peninjau',
        'tindakan'
    ];
    public function mutasi(){
        return $this->belongsTo(MutasiModel::class, 'mutasi_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
