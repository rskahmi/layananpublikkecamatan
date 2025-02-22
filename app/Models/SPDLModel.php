<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SPDLModel extends Model
{
    use HasFactory, UuidTraits;

    protected $table = 'spdl';
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
        return $this->hasMany(RiwayatSPDLModel::class, 'spdl_id', 'id');
    }
}
