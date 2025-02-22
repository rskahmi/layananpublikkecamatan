<?php

namespace App\Models;

use App\Models\TjslModel;
use App\Traits\UuidTraits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RiwayatAnggaranModel extends Model
{
    use HasFactory,UuidTraits;

    protected $table = "riwayat_anggaran";
    protected $fillable = [
        'tujuan',
        'tanggal',
        'tipe',
        'nominal',
        'sisa_anggaran',
        'tjsl_id',
        'user_id'
    ];

    public function tjsl(): BelongsTo
    {
        return $this->belongsTo(TjslModel::class);
    }

}
