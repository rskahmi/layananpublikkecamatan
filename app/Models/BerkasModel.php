<?php

namespace App\Models;

use App\Traits\UuidTraits;
use App\Models\ProposalModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BerkasModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "berkas";
    protected $fillable = [
        'nomor_berkas',
        'nama_berkas',
        'jenis',
        'tanggal',
        'nama_pengirim',
        'file_berkas',
        'contact',
        'user_id'
    ];

    public function proposal(): HasOne
    {
        return $this->hasOne(ProposalModel::class, 'berkas_id', 'id');
    }
}
