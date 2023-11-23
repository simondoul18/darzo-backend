<?php

namespace App\Services;

use App\Repositories\CustomerInfoRepository;
use App\Repositories\CustomerAddressRepository;
use Illuminate\Http\Request;

class CustomerInfoService
{
    function getCustomerInfo($id = '')
    {
        return (new CustomerInfoRepository)->getProfile($id);
    }
    function updateCustomerProfile(Request $request, $id)
    {
        $CustomerInfoRepo = new CustomerInfoRepository;
        $CustomerAddressRepo = new CustomerAddressRepository;

        $CustomerInfoRepo->update($request->all(), $id);
        $CustomerAddressRepo->createOrUpdate($request->all(), $id);

        return true;
    }

    function updateProfilePicture($url)
    {
        return (new CustomerInfoRepository)->updateCustomerProfilePicture($url);
    }
}
