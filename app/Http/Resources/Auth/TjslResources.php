<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TjslResources extends JsonResource
{
    public function toArray(Request $request)
    :array
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'anggaran' => $this->anggaran,
            'pic' => $this->pic,
            'contact' => $this->contact,
            'tanggal' => $this->tanggal,
            'terprogram' => $this->terprogram,
            'gambar' => $this->gambar,
            'lembaga_id' => $this->lembaga_id,
            'wilayah_id' => $this->wilayah_id,
            'user_id' => $this->user_id,
        ];
    }
}
