<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->product_name,
            "category" => $this->category->category_name ?? 'N/A',  // Handle potential null values
            "inventory" => [
                'quantity' => $this->inventory->quantity ?? 0, // Handle potential null values
                'status' => $this->inventory->status ?? null
            ],
            "image" => $this->image,
            "price" => (float) $this->price,
        ];
    }
}
