<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InventoriesResource extends JsonResource
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
            'location' => $this->location,
            'product' => $this->product->product_name,
            'category'=>$this->product->category->category_name,
            'quantity' => $this->quantity,
            'status' => $this->status ?? null
        ];
    }
}
