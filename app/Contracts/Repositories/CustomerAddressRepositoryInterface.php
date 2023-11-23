<?php

namespace App\Contracts\Repositories;

use App\Models\CustomerAddress;

interface CustomerAddressRepositoryInterface
{
    // public function __construct(Product $product);
    public function create(array $detail): CustomerAddress|false;
}
