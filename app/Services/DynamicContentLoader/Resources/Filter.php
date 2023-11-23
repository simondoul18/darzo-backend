<?php

namespace App\Services\DynamicContentLoader\Resources;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class Filter
{
    private ?string $content = null;

    private Builder|Model|Collection|LengthAwarePaginator $model;

    private ?LengthAwarePaginator $paginatedData = null;

    public function __construct(Model|Builder|Collection|LengthAwarePaginator $model, $content)
    {
        if ($model instanceof LengthAwarePaginator) {
            $this->paginatedData = $model;
            $this->model = $model->getCollection();
        } else {
            $this->model = $model;
        }
        $this->content = $content;
    }

    public function build($filterLoader = null): Builder|null|Model|Collection|LengthAwarePaginator
    {
        if ($this->content) {
            $toFilter = [];
            $fields = explode(';', $this->content);

            //Get all the filter content from the Field data
            foreach ($fields as $field) {
                $filterField = explode(':', $field);
                $filterContent = explode(',', $filterField[1]);
                $filterField = $filterField[0];
                $toFilter[$filterField] = $filterContent;
            }

            $filterable = array_intersect_key($toFilter, array_flip($this->model->getModel()->getFillable()));

            foreach ($filterable as $column => $value) {
                $this->model = $this->model->whereIn($column, $value);
            }

            //Load the Filter functions and dispatch the filtered content
            if ($filterLoader) {
                $filterable = array_intersect_key($toFilter, array_flip(get_class_methods($filterLoader)));

                if (count($filterable) > 0) {
                    foreach ($toFilter as $relationKey => $relationArgs) {
                        if ($this->model instanceof Collection) {
                            $this->model->each(function ($eloq) use ($filterLoader, $relationKey, $relationArgs) {
                                $modelRelations = new $filterLoader($eloq);
                                $eloq = $modelRelations->{$relationKey}($relationArgs);
                            });
                        } else {
                            $modelRelations = new $filterLoader($this->model);
                            $this->model = $modelRelations->{$relationKey}($relationArgs);
                        }
                    }
                }
            }
        }

        if ($this->paginatedData) {
            $this->paginatedData->setCollection($this->model);

            return $this->paginatedData;
        }

        return $this->model;
    }
}
