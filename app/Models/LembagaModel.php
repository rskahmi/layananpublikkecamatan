<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UuidTraits;

class LembagaModel extends Model
{
    use HasFactory, UuidTraits;
    protected $table = "lembaga";
    protected $fillable = [
        'nama_lembaga'
    ];
}
