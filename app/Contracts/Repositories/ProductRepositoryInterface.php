<?php

namespace App\Contracts\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function create(array $details): Product|bool;

    public function update(array $details, $uuid): Product|bool;

    public function delete(int $id): bool;

    public function getProductByUUID(Product|Builder $product): Model|null|Builder;

    public function getAllProducts(): Collection;

    public function getPaginatedProducts(Model|Builder $product, int $perPage): LengthAwarePaginator;
}
