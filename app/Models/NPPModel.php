<?php

namespace App\Models;
use App\Traits\UuidTraits;
use App\Models\UMDModel;
use App\Models\ReimModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class NPPModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = 'npp';
    protected $fillable = [
        'jenis',
        'tanggal',
        'user_id'
    ];

    public function umd(): HasOne{
        return $this->hasOne(UMDModel::class, 'npp_id', 'id');
    }

    public function reim(): HasOne{
        return $this->hasOne(ReimModel::class, 'npp_id', 'id');
    }
}
