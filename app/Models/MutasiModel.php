<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MutasiModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = 'mutasi';
    protected $fillable = [
        'tanggal',
        'status',
        'memoteo',
        'user_id'
    ];

    public function riwayat(){
        return $this->hasMany(RiwayatMutasiModel::class, 'mutasi_id', 'id');
    }
}
