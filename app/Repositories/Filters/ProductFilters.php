<?php

namespace App\Repositories\Filters;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ProductFilters
{
    private Product|Collection|Builder $product;

    public function __construct(Product|Collection|Builder $product)
    {
        $this->product = $product;
    }

    function categories($args)
    {
        $categoriesIds = ProductCategory::whereIn('uuid', $args)->get()->pluck('id');
        //Get the products which have specific Category Ids,
        foreach ($categoriesIds as $id) {
            $this->product = $this->product->where(function ($query) use ($id) {
                $query->whereHas('haveCategories', function ($hasQuery) use ($id) {
                    $hasQuery->where('category_id', $id);
                });
            });
        }

        return $this->product;
    }

    function search($args)
    {
        if (is_array($args) && count($args) > 0) {
            foreach ($args as $arg) {
                $this->product = $this->product->where(function (Builder $query) use ($arg) {
                    $query->where('name', 'LIKE', "%" . $arg . "%")->orWhere('description', 'LIKE', "%" . $arg . "%");
                });
            }
        }

        return $this->product;
    }

    function price_range($args)
    {
        $min = $args[0] ?? 0;
        $max = $args[1];
        if ($min > 0) {

            $this->product = $this->product->where('price', '>=', $min);
        }

        if ($max > 0) {
            $this->product = $this->product->where('price', '<=', $max);
        }

        return $this->product;
    }
}
