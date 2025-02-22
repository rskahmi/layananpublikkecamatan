<?php

namespace App\Models;

use App\Traits\UuidTraits;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatProposalModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "riwayat_proposal";

    protected $fillable = [
        'status',
        'alasan',
        'surat_balasan',
        'proposal_id',
        'user_id',
        'peninjau',
        'tindakan'
    ];

    public function proposal()
    {
        return $this->belongsTo(ProposalModel::class, 'proposal_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
