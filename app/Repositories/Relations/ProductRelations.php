<?php

namespace App\Repositories\Relations;

use App\Models\Product;
use App\Repositories\CurrencyRepository;
use App\Repositories\ProductAttributeRepository;
use App\Repositories\ProductHaveCategoryRepository;
use App\Repositories\ProductImageRepository;
use App\Repositories\ProductTagRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;

class ProductRelations
{
    private Product|Collection $product;

    public function __construct(Product|Collection $product)
    {
        $this->product = $product;
    }

    public function categories()
    {
        $productHaveCategoryRepo = new ProductHaveCategoryRepository($this->product);
        $categories = $productHaveCategoryRepo->getCategoryByProduct();
        $this->product->__set('categories', $categories);

        return $this->product;
    }

    public function attributes()
    {
        $productAttributeRepo = new ProductAttributeRepository($this->product);
        $attributes = $productAttributeRepo->getAttributesByProduct()->flatMap(function ($attribute) {
            return [
                $attribute->name => $attribute->value,
            ];
        });
        $this->product->__set('attributes', $attributes);

        return $this->product;
    }

    public function custom_attributes()
    {
        $productAttributeRepo = new ProductAttributeRepository($this->product);
        $attributes = $productAttributeRepo->getCustomAttributesByProduct();
        $this->product->__set('custom_attributes', $attributes);

        return $this->product;
    }

    public function tags()
    {
        $productTagRepo = new ProductTagRepository($this->product);
        $tags = $productTagRepo->getTagsByProduct();
        $this->product->__set('tags', $tags);

        return $this->product;
    }

    public function currency()
    {
        $currencyRepo = new CurrencyRepository($this->product);
        $currency = $currencyRepo?->getCurrency()?->get(['name as label', 'id as value'])->first();
        $this->product->__set('currency', $currency);

        return $this->product;
    }

    public function images()
    {
        $productAttributeRepo = new ProductImageRepository($this->product);
        $images = $productAttributeRepo->getImagesByProduct()->map(function ($image) {
            return [
                'url' => Storage::disk('product')->url($image->url),
                'name' => $image->name,
            ];
        });
        $this->product->__set('images', $images);

        return $this->product;
    }
}
