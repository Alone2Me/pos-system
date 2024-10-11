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
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    // Accessor to determine stock status
    public function getStatusAttribute()
    {
        return $this->quantity > 25 ? 'INSTOCK'
            : ($this->quantity > 5 ? 'LOWSTOCK' : 'OUTOFSTOCK');
    }
}
