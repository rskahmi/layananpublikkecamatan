<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;

class RiwayatKembalikanModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "riwayat_kembalikan";
    protected $fillable = [
        'status',
        'alasan',
        'kembalikan_id',
        'user_id',
        'peninjau',
        'tindakan'
    ];
    public function kembalikan(){
        return $this->belongsTo(kembalikanModel::class, 'kembalikan_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
