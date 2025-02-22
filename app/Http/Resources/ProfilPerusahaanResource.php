<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfilPerusahaanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'gambar' => asset('storage/images/RUII/' . $this->gambar) ,
            'jenis'=> $this->jenis,
            'deskripsi'=> $this->deskripsi,
            'jabatan' => $this->jabatan
        ];
    }
}
