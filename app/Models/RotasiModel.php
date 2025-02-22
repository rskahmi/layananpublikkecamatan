<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RotasiModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = 'rotasi';
    protected $fillable = [
        'tanggal',
        'status',
        'memoteo',
        'user_id'
    ];

    public function riwayat(){
        return $this->hasMany(RiwayatRotasiModel::class, 'rotasi_id', 'id');
    }
}
