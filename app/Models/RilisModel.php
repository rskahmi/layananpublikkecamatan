<?php

namespace App\Models;

use App\Traits\UuidTraits;
use App\View\Components\svg\fitur\berkas;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RilisModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "rilis";
    protected $fillable = [
        'judul',
        'deskripsi',
        'gambar',
    ];

    public function pemberitaan(): HasMany
    {
        return $this->hasMany(PemberitaanModel::class, 'rilis_id', 'id');
    }
}
