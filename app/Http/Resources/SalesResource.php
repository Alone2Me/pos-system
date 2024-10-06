<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SalesResource extends JsonResource
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
            'sale_date' =>  date('Y-m-d', strtotime($this->sale_date)),
            'customer' => [
                'id' => $this->customer_id ? 'customer_id : ' . $this->customer_id : null ,
                'name' => $this->customer ? $this->customer->customer_name : null, // Assuming you have a relationship defined
            ],
            'amount' => '$' . $this->total_amount,
            'discount' => '$' . $this->total_discount,
            'tax' => '$' . $this->total_tax,
            'total' => '$' . $this->grand_total
        ];
    }
}
