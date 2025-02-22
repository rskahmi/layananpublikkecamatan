<?php

namespace App\Models;

use App\Traits\UuidTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PemberitaanModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "pemberitaan";
    public $fillable = [
        'jenis',
        'tautan',
        'respon',
        'gambar',
        'rilis_id'
    ];
    public function rilis(): BelongsTo
    {
        return $this->belongsTo(RilisModel::class, 'rilis_id', 'id');
    }

}
