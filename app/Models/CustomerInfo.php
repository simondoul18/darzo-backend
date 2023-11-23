<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerInfo extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'phone', 'gender', 'bio', 'dob', 'created_at', 'updated_at'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = (string) Str::uuid();
        });
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
