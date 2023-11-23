<?php

namespace App\Repositories\Relations;

use App\Models\CustomerAddress;
use Illuminate\Database\Eloquent\Collection;

class CustomerAddressRelations
{
    private CustomerAddress|Collection $address;

    public function __construct(CustomerAddress|Collection $address)
    {
        $this->address = $address;
    }

    public function country()
    {
        $this->address = $this->address->load('country');

        return $this->address;
    }
}
