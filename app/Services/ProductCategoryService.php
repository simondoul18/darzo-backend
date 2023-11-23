<?php

namespace App\Services;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryService
{
    public function getDefiniteCategories(Request $request)
    {
        $category = ProductCategory::query();
        $take = 10;

        if ($request->has('search')) {
            $category->where('name', 'LIKE', '%'.$request->search.'%');
            $take = null;
        }

        if ($take > 0) {
            $category->take($take);
        }

        return $category->get();
    }
}
