<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrderItem extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'product_id', 'price'];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
