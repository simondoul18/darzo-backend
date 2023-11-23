<?php

namespace App\Contracts\Repositories;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Collection;

interface ProductImageRepositoryInterface
{
    public function __construct(Product $product);

    public function create(array $detail): ProductImage|bool;

    public function createFromArray(array $details): ProductImage|bool;

    public function update(array $details): ProductImage|bool;

    public function delete(int $id): bool;

    public function getImagesByProduct(): ?Collection;

    public function getAllImagesByProduct(): Collection;
}
