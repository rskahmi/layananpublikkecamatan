<?php

namespace App\Models;

use App\Traits\UuidTraits;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PembayaranModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "pembayaran";
    protected $fillable = [
        'jumlah_pembayaran',
        'tanggal',
        'sisa_pembayaran',
        'pumk_id',
        'user_id'
    ];
}
