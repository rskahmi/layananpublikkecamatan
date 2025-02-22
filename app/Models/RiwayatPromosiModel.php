<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;

class RiwayatPromosiModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table="riwayat_promosi";
    protected $fillable = [
        'status',
        'alasan',
        'promosi_id',
        'user_id',
        'peninjau',
        'tindakan'
    ];
    public function promosi(){
        return $this->belongsTo(PromosiModel::class, 'promosi_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
