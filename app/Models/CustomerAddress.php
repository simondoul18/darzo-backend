<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CustomerAddress extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'created_by', 'full_name', 'phone', 'email', 'address_name', 'address_line_1', 'address_line_2', 'city', 'region', 'zip', 'country_id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }

    public function country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }
}
