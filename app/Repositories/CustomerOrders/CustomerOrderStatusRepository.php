<?php

namespace App\Repositories\CustomerOrders;

use App\Models\CustomerOrderStatus;

class CustomerOrderStatusRepository
{
    public function allOrderStatuses()
    {
        return CustomerOrderStatus::all();
    }
}