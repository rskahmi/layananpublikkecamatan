<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;
use App\Models\MelayatModel;
use App\Models\DinasModel;
use App\Models\SakitModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SIJModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "sij";
    protected $fillable = [
        'jenis',
        'tanggal',
        'user_id'
    ];

    public function melayat(): HasOne{
        return $this->hasOne(MelayatModel::class, 'sij_id', 'id');
    }

    public function sakit(): HasOne{
        return $this->hasOne(SakitModel::class, 'sij_id', 'id');
    }

    public function dinas(): HasOne{
        return $this->hasOne(DinasModel::class, 'sij_id', 'id');
    }
}
