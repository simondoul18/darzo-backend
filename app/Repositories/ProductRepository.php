<?php

namespace App\Repositories;

use App\Contracts\Repositories\ProductRepositoryInterface;
use App\Models\Product;
use App\Repositories\Filters\ProductFilters;
use App\Repositories\Relations\ProductRelations;
use App\Services\DynamicContentLoader\DynamicContentLoaderService;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class ProductRepository implements ProductRepositoryInterface
{
    private $identifier = null;

    public function __construct($identifier = null)
    {
        $this->identifier = $identifier;
    }

    public function getProductInstance(): Product
    {
        return new Product();
    }

    public function getProductInstanceForProducer(): Builder
    {
        return Product::where('created_by', Auth::user()->id);
    }

    public function create(array $details): Product|bool
    {
        $transaction = DB::transaction(function () use ($details) {
            //Create the Product here
            $product = new Product;
            $product->uuid = Str::uuid();
            $product->slug = str::snake($details['name']);
            $product->created_by = Auth::user()->id;
            $product->name = $details['name'];
            $product->description = $details['description'] ?? null;
            $product->sku = $details['sku'];
            $product->sell_on_crm = $details['sell_on_crm'];
            $product->sell_on_marketplace = $details['sell_on_marketplace'];
            $product->price = $details['price'];
            $product->currency_id = $details['currency_id'];
            $product->quantity = $details['quantity'] ?? null;

            if ($product->save()) {
                //Initiate the ProductHaveCategory Repo
                (new ProductHaveCategoryRepository($product))->createFromArray($details['categories']);

                //Initiate the Attributes Repo.
                (new ProductAttributeRepository($product))->createFromArray($details['attributes']);

                //Create attribute for the custom attributes
                (new ProductAttributeRepository($product))->createCustomAttributesFromArray($details['custom_attributes']);

                //Create Product tags here
                (new ProductTagRepository($product))->createFromArray($details['tags']);

                //Create Product images here
                (new ProductImageRepository($product))->createFromArray($details['images']);

                return $product;
            }
        });

        return $transaction ? $transaction : false;
    }

    public function update(array $details, $uuid): Product|bool
    {
        $transaction = DB::transaction(function () use ($details, $uuid) {
            $product = Product::where('uuid', $uuid)->first();
            if ($product) {
                $product->name = $details['name'];
                $product->slug = str::snake($details['name']);
                $product->description = $details['description'] ?? null;
                $product->sku = $details['sku'];
                $product->sell_on_crm = $details['sell_on_crm'];
                $product->sell_on_marketplace = $details['sell_on_marketplace'];
                $product->price = $details['price'];
                $product->currency_id = $details['currency_id'];
                $product->quantity = $details['quantity'] ?? null;

                if ($product->save()) {
                    //Initiate the ProductHaveCategory Repo
                    (new ProductHaveCategoryRepository($product))->update($details['categories']);

                    //Initiate the Attributes Repo.
                    (new ProductAttributeRepository($product))->updateAttributeFromArray($details['attributes']);

                    //Create attribute for the custom attributes
                    (new ProductAttributeRepository($product))->updateCustomAttributes($details['custom_attributes']);

                    //Create Product tags here
                    (new ProductTagRepository($product))->update($details['tags']);

                    //Create Product images here
                    (new ProductImageRepository($product))->update($details['images']);

                    return $product;
                }
            }
        });

        return $transaction ? $transaction : false;
    }

    public function delete(int $id): bool
    {
        return false;
    }

    public function getProductByUUID(Product|Builder $product): Model|null|Builder
    {
        $product = $product->where('uuid', $this->identifier)->first();

        return $product;
    }

    public function getAllProducts(): Collection
    {
        return new Collection;
    }

    public function getPaginatedProducts(Model|Builder $product, int $perPage = 2): LengthAwarePaginator
    {
        $products = $product->paginate($perPage);

        return $products;
    }

    public function getProductWithRelations(Product $product, array $relations = [])
    {
        // , 'attributes', 'custom_attributes', 'tags', 'images'
        return $product->load('categories');
    }

    public function attachDynamicContent(Model|Collection|Builder $product, Request $request, string $func, $args = [])
    {
        if ($request->has('select')) {
            $dynamicLoader = new DynamicContentLoaderService($request, $product);
            $product = $dynamicLoader->withSelectOptions();
        }

        if ($request->has('filter')) {
            $dynamicLoader = new DynamicContentLoaderService($request, $product);
            $product = $dynamicLoader->withFilterOptions(ProductFilters::class);
        }

        $product = $this->{$func}($product, ...$args);

        if ($request->has('include')) {
            $dynamicLoader = new DynamicContentLoaderService($request, $product);
            $product = $dynamicLoader->withIncludeOptions(ProductRelations::class);
        }

        return $product;
    }
}
