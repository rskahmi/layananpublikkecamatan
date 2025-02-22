<?php

namespace App\Models;

use App\Traits\UuidTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WilayahModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "wilayah";
    protected $fillable = [
        'alamat',
        'kelurahan',
        'kecamatan',
        'kota',
        'latitude',
        'longitude'
    ];

    /**
     * Get the user that owns the WilayahModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tjsl(): HasMany
    {
        return $this->hasMany(TjslModel::class, 'wilayah_id', 'id');
    }

    public function pumk(): HasMany
    {
        return $this->hasMany(PumkModel::class, 'wilayah_id', 'id');
    }

    public function program(): HasMany
    {
        return $this->hasMany(ProgramUnggulanModel::class, 'wilayah_id', 'id');
    }
}
