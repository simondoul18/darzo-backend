<?php

namespace App\Contracts\Repositories;

use App\Models\Product;
use App\Models\ProductHaveTag;
use Illuminate\Database\Eloquent\Collection;

interface ProductTagRepositoryInterface
{
    public function __construct(Product $product);

    public function create(array $details): ProductHaveTag|bool;

    public function createFromArray(array $details): ProductHaveTag|bool;

    public function update(array $details): ProductHaveTag|bool;

    public function delete(int $id): bool;

    public function getTagsByProduct(): ?Collection;

    public function getAllTagsByProduct(): Collection;
}
