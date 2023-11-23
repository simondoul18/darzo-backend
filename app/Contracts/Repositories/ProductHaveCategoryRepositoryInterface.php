<?php

namespace App\Contracts\Repositories;

use App\Models\Product;
use App\Models\ProductHaveCategory;
use Illuminate\Database\Eloquent\Collection;

interface ProductHaveCategoryRepositoryInterface
{
    public function __construct(Product $product);

    public function create(array $details): ProductHaveCategory|bool;

    public function createFromArray(array $details): bool;

    public function update(array $details): ProductHaveCategory|bool;

    public function delete(int $id): bool;

    public function getCategoryByProduct(): ?Collection;

    public function getAllProductCategories(): Collection;
}
