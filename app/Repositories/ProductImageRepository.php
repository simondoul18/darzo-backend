<?php

namespace App\Repositories;

use App\Contracts\Repositories\ProductImageRepositoryInterface;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class ProductImageRepository implements ProductImageRepositoryInterface
{
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function create(array $detail): ProductImage|bool
    {
        //Create image resource in database
        $productImage = new ProductImage;
        $productImage->product_id = $this->product->id;
        $productImage->name = $detail['name'];
        $productImage->url = $detail['name'];
        //If the image exists in Temp dir then move it to product images folder
        if (Storage::disk('temp')->exists($detail['name'])) {
            Storage::disk('public')->move('/temp/'.$detail['name'], '/product-images/'.$detail['name']);
        }

        return $productImage->save() ? $productImage : false;
    }

    public function createFromArray(array $details): ProductImage|bool
    {
        if (count($details) > 0) {
            foreach ($details as $detail) {
                $this->create($detail);
            }
        }

        return true;
    }

    public function createOrUpdate(array $detail)
    {
        $productImage = $this->product->images()->where('name', $detail['name'])->first();

        if (! $productImage) {
            return $this->create($detail);
        }

        return false;
    }

    public function createOrUpdateFromArray(array $details)
    {
        if (count($details) > 0) {
            foreach ($details as $detail) {
                $this->createOrUpdate($detail);
            }
        }

        return true;
    }

    public function update(array $details): ProductImage|bool
    {
        //Get all the Tags which are not present in the List; Deleted one.
        $deletedImageIds = array_column($details, 'name');
        $deletedImages = $this->product->images()->whereNotIn('name', $deletedImageIds);
        $deletedImages->delete();
        $this->createOrUpdateFromArray($details);

        return true;
    }

    public function delete(int $id): bool
    {
        return true;
    }

    public function getImagesByProduct(): ?Collection
    {
        $images = $this->product?->images()->get(['name', 'url']);

        return $images;
    }

    public function getAllImagesByProduct(): Collection
    {
        return new Collection();
    }
}
