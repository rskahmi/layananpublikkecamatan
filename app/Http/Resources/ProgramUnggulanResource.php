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
            'nama_program'=>$this->nama_program,
            'nama_kelompok'=>$this->nama_kelompok,
            'mitra_binaan'=>$this->mitra_binaan,
            'ketua_kelompok'=>$this->ketua_kelompok,
            'contact'=>$this->contact,
            'pic'=>$this->pic,
            'deskripsi'=>$this->deskripsi,
            'gambar' => $this->gambar,
            'wilayah_id' => $this->wilayah_id,
        ];
    }
}
