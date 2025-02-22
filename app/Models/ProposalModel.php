<?php

namespace App\Models;

use App\Traits\UuidTraits;
use App\Models\LembagaModel;
use App\Models\RiwayatProposalModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProposalModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "proposal";
    protected $fillable = [
        'anggaran',
        'status',
        'total_waktu',
        'jenis',
        'berkas_id',
        'wilayah_id',
        'lembaga_id'
    ];

    public function berkas()
    {
        return $this->belongsTo(BerkasModel::class, 'berkas_id', 'id');
    }

    public function riwayat()
    {
        return $this->hasMany(RiwayatProposalModel::class, 'proposal_id', 'id');
    }

    public function lembaga(): BelongsTo
    {
        return $this->belongsTo(LembagaModel::class);
    }
    public function wilayah(): BelongsTo
    {
        return $this->belongsTo(WilayahModel::class);
    }
}
