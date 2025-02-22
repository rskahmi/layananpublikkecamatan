<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;

class RiwayatUserModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table="riwayat_user";
    protected $fillable = [
        'status',
        'alasan',
        'user_id',
        'peninjau',
        'tindakan'
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
