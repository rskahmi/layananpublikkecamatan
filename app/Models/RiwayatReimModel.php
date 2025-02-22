<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;


class RiwayatReimModel extends Model
{
    use HasFactory, UuidTraits;

    protected $table = "riwayat_reim";
    protected $fillable = [
        'status',
        'alasan',
        'reim_id',
        'user_id',
        'peninjau',
        'tindakan'
    ];

    public function reim(){
        return $this->belongsTo(ReimModel::class, 'reim_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
