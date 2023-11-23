<?php

namespace App\Contracts\Repositories;

use App\Models\Product;
use App\Models\ProductAttribute;
use Illuminate\Database\Eloquent\Collection;

interface ProductAttributeRepoisitoryInterface
{
    public function __construct(Product $product);

    public function create(array $details, bool $is_custom): ProductAttribute|bool;

    public function createCustomAttributesFromArray(array $details): ProductAttribute|bool;

    public function createFromArray(array $details): ProductAttribute|bool;

    public function updateAttributes(array $details): ProductAttribute|bool;

    public function delete(int $id): bool;

    public function getAttributesByProduct(): ?Collection;

    public function getCustomAttributesByProduct(): ?Collection;

    public function getAllProductAttributes(): Collection;
}
