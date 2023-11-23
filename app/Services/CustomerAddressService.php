<?php

namespace App\Services;

use App\Http\Requests\CustomerAddressRequest;
use App\Models\CustomerAddress;
use App\Repositories\CustomerAddressRepository;
use Illuminate\Http\Request;

class CustomerAddressService
{
    public function createAddress(CustomerAddressRequest $request): CustomerAddress|false
    {
        //Initiate the Address REpo
        $customerAddressRepo = new CustomerAddressRepository;
        $address = $customerAddressRepo->create($request->validated());

        return $address;
    }

    public function updateAddress(CustomerAddressRequest $request, $address): CustomerAddress|false
    {
        //Initiate the Address REpo
        $customerAddressRepo = new CustomerAddressRepository;
        $address = $customerAddressRepo->update($request->validated(), $address);

        return $address;
    }

    public function getAuthUserAddresses(Request $request)
    {
        $customerAddressRepo = new CustomerAddressRepository();
        $address = $customerAddressRepo->getInstance();
        if ($address) {
            $address = $customerAddressRepo->attachDynamicContent($address, $request, 'getAuthUserAddresses');
        }

        return $address;
    }
}
