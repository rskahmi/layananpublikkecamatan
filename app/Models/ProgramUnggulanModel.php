<?php

namespace App\Models;

use App\Traits\UuidTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProgramUnggulanModel extends Model
{
    use HasFactory, UuidTraits;

    protected $table = "program_unggulan";
    protected $fillable = [
        'nama_kegiatan',
        'nama_kelompok',
        'mitra',
        'contact',
        'pic',
        'deskripsi',
        'gambar',
        'user_id',
    ];

    /**
     * Get the wilayah that owns the ProgramUnggulanModel
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
}
