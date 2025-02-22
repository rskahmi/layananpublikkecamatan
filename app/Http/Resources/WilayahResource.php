<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WilayahResource extends JsonResource
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
            'alamat'=>$this->alamat,
            'kelurahan'=>$this->kelurahan,
            'kecamatan'=>$this->kecamatan,
            'kota'=>$this->kota,
            'latitude'=>$this->latitude,
            'longitude'=>$this->longitude,
        ];
    }
}
