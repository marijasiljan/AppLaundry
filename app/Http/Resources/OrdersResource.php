<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResource extends JsonResource
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
            'date' => $this->date,
            'total' => $this->total,
            'confirmed' => $this->confirmed,
            'type' => $this->type,
            'exchange' => $this->exchange,
            'user_id' => $this->user_id,
        ];
    }
}
