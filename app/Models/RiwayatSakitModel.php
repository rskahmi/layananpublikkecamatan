<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;

class RiwayatSakitModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table="riwayat_sakit";
    protected $fillable = [
        'status',
        'alasan',
        'sakit_id',
        'user_id',
        'peninjau',
        'tindakan'
    ];
    public function sakit(){
        return $this->belongsTo(SakitModel::class, 'sakit_id', 'id');
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
}
