<?php

namespace App\Repositories;

use App\Contracts\Repositories\ProductTagRepositoryInterface;
use App\Models\Product;
use App\Models\ProductHaveTag;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;

class ProductTagRepository implements ProductTagRepositoryInterface
{
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function create(array $detail): ProductHaveTag|bool
    {
        //Create produt tag here
        $productTag = new ProductHaveTag;
        $productTag->product_id = $this->product->id;
        $productTag->tag_id = $detail['value'];

        return $productTag->save() ? $productTag : false;
    }

    public function createFromArray(array $details): ProductHaveTag|bool
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
        $productTag = $this->product->haveTags()->where('id', $detail['value'])->first();

        if ($productTag) {
            //Update Product Tags here
            $productTag->product_id = $this->product->id;
            $productTag->tag_id = $detail['value'];

            return $productTag->save() ? $productTag : false;
        } else {
            return $this->create($detail);
        }

        return false;
    }

    public function createOrUpdateFromArray(array $details)
    {
        if (count($details) > 0) {
            foreach ($details as $value) {
                $this->createOrUpdate($value);
            }
        }

        return true;
    }

    public function update(array $details): ProductHaveTag|bool
    {
        //Get all the Tags which are not present in the List; Deleted one.
        $deletedProductTagIds = array_column($details, 'value');
        $deletedProductTags = $this->product->haveTags()->whereNotIn('id', $deletedProductTagIds);
        $deletedProductTags->delete();
        $this->createOrUpdateFromArray($details);

        return true;
    }

    public function delete(int $id): bool
    {
        return true;
    }

    public function getTagsByProduct(): ?Collection
    {
        $pivot = $this->product?->haveTags()->get();
        $tags = Tag::whereIn('id', $pivot->pluck('tag_id'))->get(['name as label', 'id as value']);

        return $tags;
    }

    public function getAllTagsByProduct(): Collection
    {
        return new Collection();
    }
}
