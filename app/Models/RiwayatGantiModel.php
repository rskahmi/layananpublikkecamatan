<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;

class RiwayatGantiModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "riwayat_ganti";
    protected $fillable = [
        'status',
        'alasan',
        'ganti_id',
        'user_id',
        'peninjau',
        'tindakan'
    ];
    public function ganti(){
        return $this->belongsTo(GantiModel::class, 'ganti_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
