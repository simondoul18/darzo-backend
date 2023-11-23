<?php

namespace App\Repositories\CustomerOrders;

use App\Models\CustomerOrder;
use App\Models\CustomerOrderStatus;
use App\Repositories\Relations\CustomerOrderRelations;
use App\Services\DynamicContentLoader\DynamicContentLoaderService;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerOrderRepository
{
    private $identifier = null;

    public function __construct($identifier = null)
    {
        $this->identifier = $identifier;
    }

    public function getOrderInstance(): CustomerOrder
    {
        return new CustomerOrder();
    }

    public function getOrderInstanceForCustomer(): Builder
    {
        return (new CustomerOrder())->where('customer_id', Auth::user()->id);
    }

    public function getOrderInstanceForProducer(): Builder
    {
        return (new CustomerOrder())->where('producer_id', Auth::user()->id)->where('is_paid', true);
    }

    public function create(array $details)
    {
        $transaction = DB::transaction(function () use ($details) {
            //Create Order root Instance
            $order = new CustomerOrder;
            $order->customer_id = Auth::user()->id;
            $order->reference = 'HAR' . rand(10000000000000, 99999999999999);
            $order->customer_order_status_id = CustomerOrderStatus::where('name', CustomerOrderStatus::INITIAL_STATUS)->firstOrFail()->id;
            if ($order->save()) {
                //Create Order items here
                $customerOrderItems = (new CustomerOrderItemRepository($order))->createFromArray($details['order_items'] ?? []);
                if (count($customerOrderItems) > 0) {
                    $order->producer_id = $customerOrderItems[0]->product->created_by;
                    $order->save();
                }

                //Create Customer Delivery options
                (new CustomerOrderDeliveryRepository($order))->create($details);
            }

            return $order;
        });

        return $transaction ? $transaction : false;
    }

    public function getPaginatedOrders(Model|Builder $order, int $perPage = 2): LengthAwarePaginator
    {
        $order = $order->paginate($perPage);

        return $order;
    }

    public function getOrderByUUID(CustomerOrder|Builder $order): Model|null|Builder
    {
        $order = $order->where('uuid', $this->identifier)->first();

        return $order;
    }

    public function attachDynamicContent(Model|Collection|Builder $order, Request $request, string $func, $args = [])
    {
        if ($request->has('select')) {
            $dynamicLoader = new DynamicContentLoaderService($request, $order);
            $order = $dynamicLoader->withSelectOptions();
        }

        if ($request->has('filter')) {
            $dynamicLoader = new DynamicContentLoaderService($request, $order);
            $order = $dynamicLoader->withFilterOptions();
        }

        $order = $this->{$func}($order, ...$args);

        if ($request->has('include')) {
            $dynamicLoader = new DynamicContentLoaderService($request, $order);
            $order = $dynamicLoader->withIncludeOptions(CustomerOrderRelations::class);
        }

        return $order;
    }
}
