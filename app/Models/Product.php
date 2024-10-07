<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'product_name', 'category_id', 'description', 'image', 'price', 'sku'];

    // Relationship with Categories
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    // Relationship with Inventory
    public function inventory()
    {
        return $this->hasOne(Inventory::class, 'product_id', 'id');
    }
}

