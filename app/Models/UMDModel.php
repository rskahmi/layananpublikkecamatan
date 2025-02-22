<?php

namespace App\Models;
use App\Traits\UuidTraits;
use App\Models\LembagaModel;
use App\Models\RiwayatUMDModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UMDModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "umd";
    protected $fillable = [
        'status',
        'npp_id',
        'berkasrab'
    ];

    public function npp(){
        return $this->belongsTo(NPPModel::class, 'npp_id', 'id');
    }

    public function riwayat(){
        return $this->hasMany(RiwayatUMDModel::class, 'umd_id', 'id');
    }
}
