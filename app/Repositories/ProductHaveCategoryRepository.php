<?php

namespace App\Repositories;

use App\Contracts\Repositories\ProductHaveCategoryRepositoryInterface;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductHaveCategory;
use Illuminate\Database\Eloquent\Collection;

class ProductHaveCategoryRepository implements ProductHaveCategoryRepositoryInterface
{
    private Product|Collection $product;

    public function __construct(Product|Collection $product)
    {
        $this->product = $product;
    }

    public function create(array $detail): ProductHaveCategory|bool
    {
        //Create Product Categories here
        $categoryLink = new ProductHaveCategory;
        $categoryLink->product_id = $this->product->id;
        $categoryLink->category_id = $detail['value'];

        return $categoryLink->save() ? $categoryLink : false;
    }

    public function createFromArray(array $details): bool
    {
        if (count($details) > 0) {
            foreach ($details as $value) {
                $this->create($value);
            }
        }

        return true;
    }

    public function createOrUpdate(array $detail): ProductHaveCategory|bool
    {
        $categoryLink = $this->product->haveCategories()->where('id', $detail['value'])->first();

        if ($categoryLink) {
            //Update Product Categories here
            // $categoryLink->product_id = $this->product->id;
            $categoryLink->category_id = $detail['value'];

            return $categoryLink->save() ? $categoryLink : false;
        } else {
            return $this->create($detail);
        }

        return true;
    }

    public function createOrUpdateFromArray(array $details): bool|ProductHaveCategory
    {
        if (count($details) > 0) {
            foreach ($details as $value) {
                $this->createOrUpdate($value);
            }
        }

        return true;
    }

    public function update(array $details): ProductHaveCategory|bool
    {
        //Get all the Catgories which are not present in the List; Deleted one.
        $deletedCategoriesIds = array_column($details, 'value');
        $deletedCategories = $this->product->haveCategories()->whereNotIn('id', $deletedCategoriesIds);
        $deletedCategories->delete();
        $this->createOrUpdateFromArray($details);

        return true;
    }

    public function delete(int $id): bool
    {
        return true;
    }

    public function getCategoryByProduct(): ?Collection
    {
        $pivot = $this->product?->haveCategories()->get();
        $categories = ProductCategory::whereIn('id', $pivot->pluck('category_id'))->get(['name as label', 'id as value']);

        return $categories;
    }

    public function getAllProductCategories(): Collection
    {
        return new Collection();
    }
}
