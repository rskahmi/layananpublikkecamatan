<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;


class RiwayatSPDModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table="riwayat_spd";
    protected $fillable = [
        'status',
        'alasan',
        'spd_id',
        'user_id',
        'peninjau',
        'tindakan'
    ];
    public function spd(){
        return $this->belongsTo(SPDModel::class, 'spd_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
