<?php

namespace App\Repositories\CustomerOrders;

use App\Models\CustomerOrder;
use App\Models\CustomerOrderItem;
use App\Models\Product;
use App\Repositories\ProductRepository;

class CustomerOrderItemRepository
{
    private CustomerOrder $order;

    public function __construct(CustomerOrder $order)
    {
        $this->order = $order;
    }

    public function create(array $detail): CustomerOrderItem|false
    {
        $orderItem = new CustomerOrderItem;
        $orderItem->order_id = $this->order->id;
        //Get the product from UUID
        $productRepo = new ProductRepository(identifier: $detail['product_id']);
        $product = $productRepo->getProductByUUID(new Product);

        if ($product) {
            $orderItem->product_id = $product->id;
            $orderItem->price = $product->price;

            if ($orderItem->save()) {
                return $orderItem;
            }
        }

        return false;
    }

    public function createFromArray(array $details)
    {
        $itemList = [];
        if (count($details) > 0) {
            foreach ($details as $detail) {
                $itemList[] = $this->create($detail);
            }
        }

        return $itemList;
    }
}
