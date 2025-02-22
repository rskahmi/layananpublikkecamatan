<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;

class RiwayatSPDLModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table="riwayat_spdl";
    protected $fillable = [
        'status',
        'alasan',
        'spdl_id',
        'user_id',
        'peninjau',
        'tindakan'
    ];
    public function spdl(){
        return $this->belongsTo(SPDModel::class, 'spdl_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
