<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RiwayatUMDResources extends JsonResource
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
            'status'=>$this->status,
            'alasan'=>$request->alasan,
            'umd_id'=>$this->umd_id,
            'user_id'=>$this->user_id,
            'tanggal' => format_dfy($this->created_at),
            'waktu' => format_time($this->created_at),
        ];
    }
}
