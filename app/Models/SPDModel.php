<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SPDModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = 'spd';
    protected $fillable = [
        'tanggal',
        'tanggalberangkat',
        'tanggalpulang',
        'tujuan',
        'status',
        'lampiran',
        'user_id'
    ];

    public function riwayat(){
        return $this->hasMany(RiwayatSPDModel::class, 'spd_id', 'id');
    }
}
