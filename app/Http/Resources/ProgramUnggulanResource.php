<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProgramUnggulanResource extends JsonResource
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
            'nama_kegiatan'=>$this->nama_kegiatan,
            'nama_kelompok'=>$this->nama_kelompok,
            'mitra'=>$this->mitra,
            'contact'=>$this->contact,
            'pic'=>$this->pic,
            'deskripsi'=>$this->deskripsi,
            'gambar' => $this->gambar,
        ];
    }
}
