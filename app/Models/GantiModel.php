<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Traits\UuidTraits;
use App\Models\RiwayatGantiModel;

class GantiModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "ganti";
    protected $fillable = [
        'status',
        'rd_id',
        'suratpermohonanganti',
        'simrd'
    ];

    public function rd(){
        return $this->belongsTo(RDModel::class, 'rd_id', 'id');
    }

    public function riwayat(){
        return $this->hasMany(RiwayatGantiModel::class, 'ganti_id', 'id');
    }
}
