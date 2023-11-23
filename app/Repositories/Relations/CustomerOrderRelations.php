<?php

namespace App\Repositories\Relations;

use App\Models\CustomerOrder;
use App\Services\DynamicContentLoader\Resources\Relation;
use Illuminate\Database\Eloquent\Collection;

class CustomerOrderRelations
{
    private CustomerOrder|Collection $order;

    public function __construct(CustomerOrder|Collection $order)
    {
        $this->order = $order;
    }

    public function order_items()
    {
        $this->order->load(['orderItems.product']);
        $product = $this->order->orderItems?->first()?->product;
        if ($product) {
            $relations = new Relation($product, 'categories,images,currency,attributes,custom_attributes,tags');
            $relations = $relations->build(ProductRelations::class);
            $this->order->orderItems->first()->__set('product', $relations);
        }

        return $this->order;
    }

    public function order_delivery()
    {
        $this->order->load(['orderDelivery']);

        return $this->order;
    }

    public function order_status()
    {
        $this->order->load(['status']);

        return $this->order;
    }
}
