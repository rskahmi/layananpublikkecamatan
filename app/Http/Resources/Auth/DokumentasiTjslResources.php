<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DokumentasiTjslResources extends JsonResource
{
    public function toArray(Request $request)
    :array
    {
        return [
            'id' => $this->id,
            'nama_kegiatan' => $this->nama_kegiatan,
            'tanggal' => $this->tanggal,
            'nama_file' => $this->nama_file,
            'jenis_file' => $this->jenis_file,
            'tjsl_id' => $this->tjsl_id,
            'user_id' => $this->user_id, 
        ];
    }
}
