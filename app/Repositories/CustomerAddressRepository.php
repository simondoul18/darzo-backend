<?php

namespace App\Repositories;

use App\Contracts\Repositories\CustomerAddressRepositoryInterface;
use App\Models\CustomerAddress;
use App\Repositories\Relations\CustomerAddressRelations;
use App\Services\DynamicContentLoader\DynamicContentLoaderService;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class CustomerAddressRepository implements CustomerAddressRepositoryInterface
{
    public function __construct()
    {
    }

    public function getInstance()
    {
        return new CustomerAddress();
    }

    public function create(array $detail): CustomerAddress|false
    {
        $address = new CustomerAddress;
        $address->created_by = Auth::user()->id;
        $address->full_name = $detail['full_name'];
        $address->phone = $detail['phone'] ?? null;
        $address->email = $detail['email'] ?? null;
        $address->address_name = $detail['address_name'];
        $address->address_line_1 = $detail['address_line_1'];
        $address->address_line_2 = $detail['address_line_2'] ?? null;
        $address->city = $detail['city'];
        $address->region = $detail['region'];
        $address->zip = $detail['zip'];
        $address->country_id = $detail['country_id'];

        return $address->save() ? $address : false;
    }

    public function update(array $detail, $addressId): CustomerAddress|false
    {
        $address = CustomerAddress::find($addressId);
        if ($address) {
            $address->full_name = $detail['full_name'];
            $address->phone = $detail['phone'] ?? null;
            $address->email = $detail['email'] ?? null;
            $address->address_name = $detail['address_name'];
            $address->address_line_1 = $detail['address_line_1'];
            $address->address_line_2 = $detail['address_line_2'] ?? null;
            $address->city = $detail['city'];
            $address->region = $detail['region'];
            $address->zip = $detail['zip'];
            $address->country_id = $detail['country_id'];

            return $address->save() ? $address : false;
        }

        return false;
    }

    public function getAuthUserAddresses(CustomerAddress|Builder|Collection $address)
    {
        $address = $address->where('created_by', Auth::user()->id)->get();

        return $address;
    }

    public function getAuthUserAddressById(int $id): CustomerAddress|false
    {
        $address = CustomerAddress::where('created_by', Auth::user()->id)->find($id);

        return $address ?? false;
    }

    public function attachDynamicContent(Model|Collection|Builder $address, Request $request, string $func, $args = [])
    {
        if ($request->has('select')) {
            $dynamicLoader = new DynamicContentLoaderService($request, $address);
            $address = $dynamicLoader->withSelectOptions();
        }

        if ($request->has('filter')) {
            $dynamicLoader = new DynamicContentLoaderService($request, $address);
            $address = $dynamicLoader->withFilterOptions();
        }

        $address = $this->{$func}($address, ...$args);

        if ($request->has('include')) {
            $dynamicLoader = new DynamicContentLoaderService($request, $address);
            $address = $dynamicLoader->withIncludeOptions(CustomerAddressRelations::class);
        }

        return $address;
    }
    function createOrUpdate($request,$id)
    {
        $resp = CustomerAddress::updateOrCreate(
            ['created_by' => $id],
            [ 
                'country_id' => $request['address']['country'], 
                'zip' => $request['address']['postalCode'],
                'region' => $request['address']['state'],
                'city' => empty($request['address']['city'])? null:$request['address']['city'],
                'full_name' => $request['name'], 
                'address_line_1' => $request['address']['address'], 
                'address_name' => 'default'
            ]
        );
        return $resp;
    }
}
