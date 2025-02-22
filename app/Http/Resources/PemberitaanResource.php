<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PemberitaanResource extends JsonResource
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
            'jenis'=> $this->jenis,
            'tautan'=> $this->tautan,
            'respon'=> $this->respon,
            'gambar' => asset('storage/images/media/' . $this->gambar) ,
            'rilis_id'=>$this->media_id,
            'user_id'=>$this->user_id,
        ];
    }
}
