<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\UuidTraits;
use App\Models\RiwayatBaruModel;

class BaruModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "baru";
    protected $fillable = [
        'status',
        'rd_id',
        'suratpermohonanbaru'
    ];

    public function rd(){
        return $this->belongsTo(RDModel::class, 'rd_id', 'id');
    }
    public function riwayat(){
        return $this->hasMany(RiwayatBaruModel::class, 'baru_id', 'id');
    }
}
