<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RilisResources extends JsonResource
{
    public function toArray(Request $request)
    :array
    {
        return [
            'id' => $this->id,
            'judul' => $this->judul,
            'deskripsi' => $this->deskripsi,
            'gambar' => asset('storage/images/media/' . $this->gambar) ,
        ];
    }
}
