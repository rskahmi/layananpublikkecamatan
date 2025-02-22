<?php

namespace App\Models;


use App\Traits\UuidTraits;
use App\Models\LembagaModel;
use App\Models\RiwayatMelayatModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MelayatModel extends Model
{
    use HasFactory, UuidTraits;

    protected $table = "melayat";
    protected $fillable = [
        'status',
        'sij_id',
        'emailberitaduka'
    ];

    public function sij(){
        return $this->belongsTo(SIJModel::class, 'sij_id', 'id');
    }
    public function riwayat(){
        return $this->hasMany(RiwayatMelayatModel::class, 'melayat_id', 'id');
    }
}
