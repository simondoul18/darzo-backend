<?php

namespace App\Http\Controllers;

use App\Http\ApiResponseBuilder;
use App\Http\Requests\CustomerAddressRequest;
use App\Models\CustomerAddress;
use App\Services\CustomerAddressService;
use Illuminate\Http\Request;

class CustomerAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $addressService = new CustomerAddressService;
        $address = $addressService->getAuthUserAddresses($request);

        return $address ?
            ApiResponseBuilder::asSuccess()->withData($address)->build() :
            ApiResponseBuilder::asError(429)->withMessage('There is a problem while fetching addresses.')->build();
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
    public function store(CustomerAddressRequest $request)
    {
        $customerAddressService = new CustomerAddressService;

        $address = $customerAddressService->createAddress($request);

        return
            $address ?
            ApiResponseBuilder::asSuccess()->withData($address)->build() :
            ApiResponseBuilder::asError(429)->withMessage('There is a problem while adding address.')->build();
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerAddress $customerAddress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerAddress $customerAddress)
    {
        dd($customerAddress);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerAddressRequest $request, $customerAddress)
    {
        $customerAddressService = new CustomerAddressService;

        $address = $customerAddressService->updateAddress($request, $customerAddress);

        return
            $address ?
            ApiResponseBuilder::asSuccess()->withData($address)->build() :
            ApiResponseBuilder::asError(429)->withMessage('There is a problem while adding address.')->build();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerAddress $customerAddress)
    {
        //
    }
}
