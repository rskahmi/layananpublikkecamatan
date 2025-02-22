<?php

namespace App\Models;

use App\Traits\UuidTraits;
use App\Models\LembagaModel;
use App\Models\RiwayatDinasModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DinasModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "dinas";
    protected $fillable = [
        'status',
        'sij_id',
        'lampiran'
    ];

    public function sij(){
        return $this->belongsTo(SIJModel::class, 'sij_id', 'id');
    }

    public function riwayat(){
        return $this->hasMany(RiwayatDinasModel::class, 'dinas_id', 'id');
    } 
}
