<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;

class RiwayatDinasModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table="riwayat_dinas";
    protected $fillable = [
        'status',
        'alasan',
        'dinas_id',
        'user_id',
        'peninjau',
        'tindakan'
    ];
    public function dinas(){
        return $this->belongsTo(DinasModel::class, 'dinas_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
