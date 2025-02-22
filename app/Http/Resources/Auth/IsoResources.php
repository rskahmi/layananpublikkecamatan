<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IsoResources extends JsonResource
{
    public function toArray(Request $request)
    :array
    {
        return [
            'id' => $this->id,
            'nama' => $this->nama,
            'jenis' => $this->jenis,
            'masa_berlaku' => $this->masa_berlaku,
            'tgl_berakhir' => $this->tgl_berakhir,
            'status' => $this->status,
            'user_id' => $this->user_id,
        ];
    }
}
