<?php

namespace App\Models;

use App\Traits\UuidTraits;
use App\Models\RiwayatPenerbitanModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PenerbitanModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "penerbitan";
    protected $fillable = [
        'jenis',
        'tanggal',
        'status',
        'user_id'
    ];

    public function riwayat(){
        return $this->hasMany(RiwayatPenerbitanModel::class, 'penerbitan_id', 'id');
    }
}
