<?php

namespace App\Services\CustomerOrders;

use App\Http\Requests\CustomerOrderRequest;
use App\Repositories\CustomerOrders\CustomerOrderRepository;
use Illuminate\Http\Request;

class CustomerOrderService
{
    public function createOrder(CustomerOrderRequest $request)
    {
        return (new CustomerOrderRepository)->create($request->validated());
    }

    public function getOrderForCustomer(Request $request, $uuid)
    {
        $orderRepo = new CustomerOrderRepository(identifier: $uuid);
        $order = $orderRepo->getOrderInstanceForCustomer();
        if ($order) {
            $order = $orderRepo->attachDynamicContent($order, $request, 'getOrderByUUID');
        }

        return $order;
    }

    public function getOrderForProducer(Request $request, $uuid)
    {
        $orderRepo = new CustomerOrderRepository(identifier: $uuid);
        $order = $orderRepo->getOrderInstanceForProducer();
        if ($order) {
            $order = $orderRepo->attachDynamicContent($order, $request, 'getOrderByUUID');
        }

        return $order;
    }

    public function getPaginatedOrdersForCustomer(Request $request)
    {
        $orderRepo = new CustomerOrderRepository();
        $order = $orderRepo->getOrderInstanceForCustomer();
        if ($order) {
            $order = $orderRepo->attachDynamicContent($order, $request, 'getPaginatedOrders', ['perPage' => $request->perPage ?? 10]);
        }

        return $order;
    }

    public function getPaginatedOrdersForProducer(Request $request)
    {
        $orderRepo = new CustomerOrderRepository();
        $order = $orderRepo->getOrderInstanceForProducer();
        if ($order) {
            $order = $orderRepo->attachDynamicContent($order, $request, 'getPaginatedOrders', ['perPage' => $request->perPage ?? 10]);
        }

        return $order;
    }
}
