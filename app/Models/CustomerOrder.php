<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CustomerOrder extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'uuid', 'reference', 'is_paid'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function orderItems()
    {
        return $this->hasMany(CustomerOrderItem::class, 'order_id', 'id');
    }

    public function orderDelivery()
    {
        return $this->hasOne(CustomerOrderDelivery::class, 'order_id', 'id');
    }

    public function status()
    {
        return $this->hasOne(CustomerOrderStatus::class, 'id', 'customer_order_status_id');
    }
}
