<?php

namespace App\Http\Resources;

// use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesDetailsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_id' => $this->product_id,
            'total_quantity_sold' => (float)$this->total_quantity_sold,
            'total_sales' => (float)$this->total_sales,
            'product_name' => $this->product->product_name, // Accessing the product name
            'category_name' => $this->product->category->category_name, // Accessing the category name
            'sales_percentage' => $this->sales_percentage ?? '%0', // Include the sales percentage,
        ];
    }
}
