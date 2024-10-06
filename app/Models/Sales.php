<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sales extends Model
{
    use HasFactory;

    protected $fillable = ['id','customer_id', 'sale_date', 'amount'];

    public function customer()
    {

        return $this->belongsTo(Customer::class);
    }
}
