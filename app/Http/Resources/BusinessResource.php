<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BusinessResource extends JsonResource
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
            'name' => $this->name,
            'qr_code' => $this->qr_code,
            'image' => $this->image,
            'balance' => $this->balance,
            'address' => $this->address,
            'discount_percentage' => $this->discount_percentage,
            'allow_negative' => $this->allow_negative,
            'user_id' => $this->user_id,
        ];
    }
}
