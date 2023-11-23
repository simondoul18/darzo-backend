<?php

namespace App\Repositories;

use App\Contracts\Repositories\ProductAttributeRepoisitoryInterface;
use App\Models\Product;
use App\Models\ProductAttribute;
use Auth;
use Illuminate\Database\Eloquent\Collection;

class ProductAttributeRepository implements ProductAttributeRepoisitoryInterface
{
    private Product $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    public function create(array $detail, bool $is_custom = false): ProductAttribute|bool
    {
        //Create the Attribute here
        $attribute = new ProductAttribute;
        $attribute->created_by = Auth::user()->id;
        $attribute->product_id = $this->product->id;
        $attribute->name = $detail['name'];
        $attribute->value = $detail['value'];
        $attribute->is_custom = $is_custom;

        return $attribute->save() ? $attribute : false;
    }

    public function createOrUpdate(array $detail, $is_custom = false): bool|ProductAttribute
    {
        $attributes = $this->product->customAttributes;
        $attribute = $attributes->where('name', $detail['name'])->first();

        if ($attribute) {
            $attribute->name = $detail['name'];
            $attribute->value = $detail['value'];
            $attribute->is_custom = $is_custom;

            return $attribute->save() ? $attribute : false;
        } else {
            return $this->create(detail: $detail, is_custom: $is_custom);
        }

        return false;
    }

    public function updateCustomAttributes(array $details): bool|ProductAttribute
    {
        //Delete the Custom attribute which are not in the List
        $deletedAttributeIds = array_column($details, 'value');
        $deletedAttributes = $this->product->customAttributes()->whereNotIn('id', $deletedAttributeIds);
        $deletedAttributes->delete();

        return $this->createOrUpdateFromArray($details, is_custom: true);
    }

    public function createCustomAttributesFromArray(array $details): bool
    {
        if (count($details) > 0) {
            foreach ($details as $detail) {
                $this->create(detail: $detail, is_custom: true);
            }
        }

        return true;
    }

    public function createFromArray(array $details): ProductAttribute|bool
    {
        if (count($details) > 0) {
            foreach ($details as $name => $value) {
                $this->create(detail: [
                    'name' => $name,
                    'value' => $value,
                ], is_custom: false);
            }
        }

        return true;
    }

    public function updateFromArray(array $details, $is_custom = false)
    {
        if (count($details) > 0) {
            foreach ($details as $name => $value) {
                $this->createOrUpdate(detail: [
                    'name' => $name,
                    'value' => $value,
                ], is_custom: $is_custom);
            }
        }

        return true;
    }

    public function createOrUpdateFromArray(array $details, $is_custom = false)
    {
        if (count($details) > 0) {
            foreach ($details as $name => $value) {
                $this->createOrUpdate(detail: [
                    'name' => $value['name'],
                    'value' => $value['value'],
                ], is_custom: $is_custom);
            }
        }

        return true;
    }

    public function updateAttributes(array $detail): bool|ProductAttribute
    {
        $attributes = $this->product->attributes;
        $attribute = $attributes->where('name', $detail['name'])->first();

        if ($attribute) {
            $attribute->name = $detail['name'];
            $attribute->value = $detail['value'];

            return $attribute->save() ? $attribute : false;
        } else {
            return $this->create(detail: $detail);
        }

        return false;
    }

    public function updateAttributeFromArray(array $details)
    {
        if (count($details) > 0) {
            foreach ($details as $name => $value) {
                $this->updateAttributes(detail: [
                    'name' => $name,
                    'value' => $value,
                ]);
            }
        }

        return true;
    }

    public function delete(int $id): bool
    {
        return true;
    }

    public function getAttributesByProduct(): ?Collection
    {
        $attributes = $this->product?->attributes()->get(['name', 'value']);

        return $attributes;
    }

    public function getCustomAttributesByProduct(): ?Collection
    {
        $attributes = $this->product?->customAttributes()->get(['name', 'value']);

        return $attributes;
    }

    public function getAllProductAttributes(): Collection
    {
        return new Collection();
    }
}
