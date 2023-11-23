<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'created_by', 'name', 'description', 'quantity', 'sku', 'sell_on_crm', 'sell_on_marketplace', 'price', 'currency_id', 'scheduled_on', 'slug', 'uuid'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function haveCategories()
    {
        return $this->hasMany(ProductHaveCategory::class, 'product_id', 'id');
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id', 'id')->where('is_custom', false);
    }

    public function customAttributes()
    {
        return $this->hasMany(ProductAttribute::class, 'product_id', 'id')->where('is_custom', true);
    }

    public function haveTags()
    {
        return $this->hasMany(ProductHaveTag::class, 'product_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function currency()
    {
        return $this->hasOne(Currency::class, 'id', 'currency_id');
    }
}
