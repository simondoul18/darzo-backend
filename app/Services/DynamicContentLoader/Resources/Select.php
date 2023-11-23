<?php

namespace App\Services\DynamicContentLoader\Resources;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class Select
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

    public function build(): Builder|null|Model|LengthAwarePaginator
    {
        if ($this->content) {
            $fields = explode(',', $this->content);
            //Get Common Fields
            $modelFields = $this->model->getModel()->getFillable();
            $fields = array_intersect($fields, $modelFields);
            if (count($fields) > 0) {
                return $this->model->select($fields);
            }
        }

        if ($this->paginatedData) {
            $this->paginatedData->setCollection($this->model);

            return $this->paginatedData;
        }

        return $this->model;
    }
}
