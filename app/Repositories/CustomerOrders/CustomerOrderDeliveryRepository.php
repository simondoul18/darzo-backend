<?php

namespace App\Repositories\CustomerOrders;

use App\Models\CustomerOrder;
use App\Models\CustomerOrderDelivery;
use App\Repositories\CustomerAddressRepository;
use Auth;

class CustomerOrderDeliveryRepository
{
    private CustomerOrder $order;

    public function __construct(CustomerOrder $order)
    {
        $this->order = $order;
    }

    public function create(array $detail): CustomerOrderDelivery|false
    {
        //Get the address from the Address Repo
        $addressRepo = new CustomerAddressRepository;
        $address = $addressRepo->getAuthUserAddressById($detail['address_id']);

        if ($address) {
            $orderDelivery = new CustomerOrderDelivery;
            $orderDelivery->created_by = Auth::user()->id;
            $orderDelivery->full_name = $address->full_name;
            $orderDelivery->phone = $address->phone ?? null;
            $orderDelivery->email = $address->email ?? null;
            $orderDelivery->address_line_1 = $address->address_line_1;
            $orderDelivery->address_line_2 = $address->address_line_2 ?? null;
            $orderDelivery->city = $address->city;
            $orderDelivery->region = $address->region;
            $orderDelivery->zip = $address->zip;
            $orderDelivery->country_id = $address->country_id;
            $orderDelivery->order_id = $this->order->id;

            return $orderDelivery->save() ? $orderDelivery : false;
        }

        return false;
    }

    public function createFromArray(array $details)
    {
        if (count($details) > 0) {
            foreach ($details as $detail) {
                $this->create($detail);
            }
        }
    }
}
