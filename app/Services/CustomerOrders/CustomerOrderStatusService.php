<?php

namespace App\Services\CustomerOrders;

use App\Repositories\CustomerOrders\CustomerOrderStatusRepository;

class CustomerOrderStatusService
{
    public function fetchAllOrderStatuses()
    {
        return (new CustomerOrderStatusRepository)->allOrderStatuses();
    }
}
