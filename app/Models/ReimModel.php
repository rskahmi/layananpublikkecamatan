<?php

namespace App\Models;

use App\Traits\UuidTraits;
use App\Models\LembagaModel;
use App\Models\RiwayatReimModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReimModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = 'reim';
    protected $fillable = [
        'status',
        'npp_id',
        'berkasnpp',
        'nota',
        'kwitansi',
        'dokumenpersetujuan'
    ];
    public function npp(){
        return $this->belongsTo(NPPModel::class, 'npp_id', 'id');
    }
    public function riwayat(){
        return $this->hasMany(RiwayatReimModel::class, 'reim_id', 'id');
    }
}
