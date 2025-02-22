<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;

class RiwayatMelayatModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table="riwayat_melayat";
    protected $fillable = [
        'status',
        'alasan',
        'melayat_id',
        'user_id',
        'peninjau',
        'tindakan'
    ];
    public function melayat(){
        return $this->belongsTo(MelayatModel::class, 'melayat_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
