<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PengumumanResources extends JsonResource
{
    public function toArray(Request $request)
    :array
    {
        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'foto' => asset('storage/images/berita/' . $this->foto) ,
        ];
    }
}

