<?php

namespace App\Models;

use App\Traits\UuidTraits;
use App\Models\LembagaModel;
use App\Models\RiwayatSakitModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SakitModel extends Model
{
    use HasFactory, UuidTraits ;

    protected $table = "sakit";
    protected $fillable = [
        'status',
        'sij_id',
        'suratrujukan',
        'suratpengantar'
    ];

    public function sij(){
        return $this->belongsTo(SIJModel::class, 'sij_id', 'id');
    }

    public function riwayat(){
        return $this->hasMany(RiwayatSakitModel::class, 'sakit_id', 'id');
    }
}
