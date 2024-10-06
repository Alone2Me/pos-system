<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;



    protected $fillable = ['id', 'product_id', 'quantity']; // Added product_id to link to Products

    // Define relationship with Products if needed (optional, inverse relation)
    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }

     // Accessor to determine stock status
     public function getStatusAttribute()
     {
         if ($this->quantity > 5) {
             return 'instock';
         } elseif ($this->quantity > 0) {
             return 'lowstock';
         } else {
             return 'outofstock';
         }
     }
}
