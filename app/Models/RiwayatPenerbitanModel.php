<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;

class RiwayatPenerbitanModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table="riwayat_penerbitan";
    protected $fillable = [
        'status',
        'alasan',
        'penerbitan_id',
        'user_id',
        'peninjau',
        'tindakan'
    ];
    
    public function penerbitan(){
        return $this->belongsTo(PenerbitanModel::class, 'penerbitan_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
