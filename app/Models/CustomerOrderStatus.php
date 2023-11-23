<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrderStatus extends Model
{
    use HasFactory;

    const INITIAL_STATUS = 'Payment pending';
}
