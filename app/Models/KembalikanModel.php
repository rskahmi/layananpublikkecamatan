<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\UuidTraits;
use App\Models\RiwayatKembalikanModel;

class KembalikanModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "kembalikan";
    protected $fillable = [
        'status',
        'rd_id',
        'suratpermohonankembalikan'
    ];

    public function rd(){
        return $this->belongsTo(RDModel::class, 'rd_id', 'id');
    }
    public function riwayat(){
        return $this->hasMany(RiwayatKembalikanModel::class, 'kembalikan_id', 'id');
    }
}
