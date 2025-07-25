<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhuongTienResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
           return [
            'id' => $this->id,
            'loai_xe' => $this->loai_xe,
            'bien_so' => $this->bien_so,
            'mau_xe' => $this->mau_xe,
            'ghi_chu' => $this->ghi_chu,
            'created_at' => $this->created_at->toIso8601String(),
        ];
    }
}
