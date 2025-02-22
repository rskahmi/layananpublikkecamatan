<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnggaranTjslResources extends JsonResource
{
    public function toArray(Request $request)
    :array
    {
        return [
            'id' => $this->id,
            'tujuan' => $this->tujuan,
            'tanggal' => $this->tanggal,
            'nominal' => $this->nominal,
            'sisa_anggaran' => $this->sisa_anggaran,
            'tjsl_id' => $this->tjsl_id,
            'user_id' => $this->user_id,
        ];
    }
}
