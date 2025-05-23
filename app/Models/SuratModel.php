<?php

namespace App\Models;
use App\Traits\UuidTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SuratModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table='surat';
    protected $fillable = [
        'jenis',
        'tanggal',
        'user_id'
    ];

    public function bbm(): HasOne{
        return $this->hasOne(BBMModel::class, 'surat_id', 'id');
    }
    public function ktp(): HasOne{
        return $this->hasOne(KTPModel::class, 'surat_id', 'id');
    }
    public function kk(): HasOne{
        return $this->hasOne(KKModel::class, 'surat_id', 'id');
    }
    public function sktm(): HasOne{
        return $this->hasOne(SKTMModel::class, 'surat_id', 'id');
    }
}
