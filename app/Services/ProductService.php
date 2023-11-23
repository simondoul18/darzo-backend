<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use Illuminate\Http\Request;

class ProductService
{
    public function createProduct(Request $request)
    {
        return (new ProductRepository)->create($request->all());
    }

    public function getProduct(string $uuid, ?string $slug, Request $request)
    {
        $productRepo = new ProductRepository(identifier: $uuid);
        $product = $productRepo->getProductInstance();
        if ($product) {
            $product = $productRepo->attachDynamicContent($product, $request, 'getProductByUUID');
        }

        return $product;
    }

    public function getPaginatedProducerProducts(Request $request)
    {
        $productRepo = new ProductRepository();
        $product = $productRepo->getProductInstanceForProducer();
        if ($product) {
            $product = $productRepo->attachDynamicContent($product, $request, 'getPaginatedProducts', ['perPage' => $request->perPage ?? 10]);
        }

        return $product;
    }

    public function updateProduct(Request $request, $uuid)
    {
        return (new ProductRepository)->update($request->all(), $uuid);
    }

    public function getPaginatedProducts(Request $request)
    {
        $productRepo = new ProductRepository();
        $product = $productRepo->getProductInstance();
        if ($product) {
            $product = $productRepo->attachDynamicContent($product, $request, 'getPaginatedProducts', ['perPage' => $request->perPage ?? 10]);
        }

        return $product;
    }
}
