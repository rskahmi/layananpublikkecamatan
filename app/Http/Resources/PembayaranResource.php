<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PembayaranResource extends JsonResource
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
            'jumlah_pembayaran'=>$this->jumlah_pembayaran,
            'tanggal'=>$this->tanggal,
            'bukti'=>$this->bukti,
            'sisa_pembayaran'=>$this->sisa_pembayaran,
            'pumk_id'=>$this->pumk_id,
            'user_id'=>$this->user_id,
        ];
    }
}
