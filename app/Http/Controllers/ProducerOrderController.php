<?php

namespace App\Http\Controllers;

use App\Http\ApiResponseBuilder;
use App\Services\CustomerOrders\CustomerOrderService;
use Illuminate\Http\Request;

class ProducerOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $productService = new CustomerOrderService;
        $product = $productService->getPaginatedOrdersForProducer(request: $request);

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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $productService = new CustomerOrderService;
        $product = $productService->getOrderForProducer(request: $request, uuid: $id);

        return ApiResponseBuilder::asSuccess()->withData($product)->build();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
