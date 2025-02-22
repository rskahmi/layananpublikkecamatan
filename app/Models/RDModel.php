<?php

namespace App\Models;

use App\Traits\UuidTraits;
use App\Models\BaruModel;
use App\Models\GantiModel;
use App\Models\KembalikanModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;



class RDModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = 'rd';
    protected $fillable = [
        'jenis',
        'tanggal',
        'user_id'
    ];

    public function baru(): HasOne{
        return $this->hasOne(BaruModel::class, 'rd_id', 'id');
    }
    public function ganti(): HasOne{
        return $this->hasOne(GantiModel::class, 'rd_id', 'id');
    }
    public function kembalikan(): HasOne{
        return $this->hasOne(KembalikanModel::class, 'rd_id', 'id');
    }
}
