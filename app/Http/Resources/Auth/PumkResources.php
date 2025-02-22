<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PumkResources extends JsonResource
{
    public function toArray(Request $request)
    :array
    {
        return [
            'id' => $this->id,
            'nama_usaha' => $this->nama_usaha,
            'nama_pengusaha' => $this->nama_pengusaha,
            'contact' => $this->contact,
            'agunan' => $this->agunan,
            'anggaran' => $this->anggaran,
            'tanggal' => $this->tanggal,
            'jatuh_tempo' => $this->jatuh_tempo,
            'status' => $this->status,
            'lembaga_id' => $this->lembaga_id,
            'wilayah_id' => $this->wilayah_id,
            'user_id' => $this->user_id,
        ];
    }
}
