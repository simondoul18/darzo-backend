<?php

namespace App\Http\Controllers;

use App\Http\ApiResponseBuilder;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $productService = new ProductService;
        $product = $productService->getPaginatedProducts(request: $request);

        return ApiResponseBuilder::asSuccess()->withData($product)->build();
    }

    function producerProducts(Request $request)
    {
        $productService = new ProductService;
        $product = $productService->getPaginatedProducerProducts(request: $request);

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
    public function store(ProductRequest $request)
    {
        $productService = new ProductService;

        $product = $productService->createProduct($request);

        return
            $product ?
            ApiResponseBuilder::asSuccess()->withData($product)->build() :
            ApiResponseBuilder::asError(429)->withMessage('There is a problem while creating a product.')->build();
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $uuid, $slug = null)
    {
        $productService = new ProductService;
        $product = $productService->getProduct(uuid: $uuid, slug: $slug, request: $request);

        return ApiResponseBuilder::asSuccess()->withData($product)->build();
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, $uuid)
    {
        $productService = new ProductService;

        $product = $productService->updateProduct($request, $uuid);

        return
            $product ?
            ApiResponseBuilder::asSuccess()->withData($product)->build() :
            ApiResponseBuilder::asError(429)->withMessage('There is a problem while updating a product.')->build();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
