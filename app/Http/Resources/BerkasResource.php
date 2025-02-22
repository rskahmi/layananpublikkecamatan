<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BerkasResource extends JsonResource
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
            'nomor_berkas'=>$this->nomor_berkas,
            'nama_berkas'=>$this->nama_berkas,
            'jenis'=>$this->jenis,
            'tanggal'=>$this->tanggal,
            'nama_pengirim'=>$this->nama_pengirim,
            'file_berkas' => $this->file_berkas,
            'contact' => $this->contact,
            'user_id'=>$this->user_id,
        ];
    }
}
