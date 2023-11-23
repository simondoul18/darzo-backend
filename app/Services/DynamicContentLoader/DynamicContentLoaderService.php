<?php

namespace App\Services\DynamicContentLoader;

use App\Services\DynamicContentLoader\Resources\Filter;
use App\Services\DynamicContentLoader\Resources\Relation;
use App\Services\DynamicContentLoader\Resources\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class DynamicContentLoaderService
{
    /**
     * Methods
     * Select: this is for Parent Model only
     * include: this will load the relation
     * include:relation:field;relation2:field,field2
     *
     * Filter: This will get the data based on the specific filter criteria defined.
     * Filter will only be used for root Model
     *
     * Priority
     * 1: Select
     * 2: Filters
     * 3: Include
     */
    private Select $select;

    private Filter $filter;

    private Relation $include;

    private Builder|Model|Collection|LengthAwarePaginator $model;

    public function __construct(Request $request, Builder|Model|Collection|LengthAwarePaginator $model)
    {
        $this->model = $model;
        $this->boot($request);
    }

    public function boot(Request $request)
    {
        $this->select = new Select(model: $this->model, content: $request->select);
        $this->filter = new Filter(model: $this->model, content: $request->filter);
        $this->include = new Relation(model: $this->model, content: $request->include);
    }

    public function withSelectOptions()
    {
        return $this->select->build();
    }

    public function withFilterOptions($filterLoader = null)
    {
        return $this->filter->build($filterLoader);
    }

    public function withIncludeOptions($relationLoader)
    {
        return $this->include->build($relationLoader);
    }
}
