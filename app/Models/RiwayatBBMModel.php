<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;

class RiwayatBBMModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = 'riwayat_bbm';
    protected $fillable = [
        'status',
        'alasan',
        'bbm_id',
        'user_id',
        'peninjau',
        'tindakan'
    ];
    public function bbm(){
        return $this->belongsTo(BBMModel::class, 'bbm_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
