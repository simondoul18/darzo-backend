<?php

namespace App\Http\Controllers;

use App\Http\ApiResponseBuilder;
use App\Http\Requests\CustomerOrderRequest;
use App\Models\CustomerOrder;
use App\Services\CustomerOrders\CustomerOrderService;
use Illuminate\Http\Request;

class CustomerOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $productService = new CustomerOrderService;
        $product = $productService->getPaginatedOrdersForCustomer(request: $request);

        return ApiResponseBuilder::asSuccess()->withData($product)->build();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerOrderRequest $request)
    {
        $customerOrderService = new CustomerOrderService;
        $order = $customerOrderService->createOrder($request);

        return $order ?
            ApiResponseBuilder::asSuccess()->withData($order)->build() :
            ApiResponseBuilder::asError(429)->withMessage('There is a problem while creating order.')->build();
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $uuid)
    {
        $productService = new CustomerOrderService;
        $product = $productService->getOrderForCustomer(request: $request, uuid: $uuid);

        return ApiResponseBuilder::asSuccess()->withData($product)->build();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerOrder $customerOrder)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomerOrder $customerOrder)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerOrder $customerOrder)
    {
        //
    }
}
