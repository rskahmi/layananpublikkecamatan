<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProposalResource extends JsonResource
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
            'anggaran'=>$this->anggaran,
            'status'=>$this->status,
            'waktu_terakhirproses'=>$this->waktu_terakhirproses,
            'peninjau' => $this->peninjau,
            'kategori' => $this->kategori,
            'berkas_id'=>$this->berkas_id,
        ];
    }
}
