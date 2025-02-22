<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DokumentasiPumkResource extends JsonResource
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
            'tanggal'=>$this->tanggal,
            'nama_file'=>$this->nama_file,
            'jenis_file'=>$this->jenis_file,
            'pumk_id'=>$this->pum_id,
            'user_id'=>$this->user_id,
        ];
    }
}
