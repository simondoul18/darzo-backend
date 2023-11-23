<?php

namespace App\Services\DynamicContentLoader\Resources;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class Relation
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

    public function build($relationLoader): Builder|null|Model|Collection|LengthAwarePaginator
    {
        if ($this->content) {
            $relations = explode(',', $this->content);
            //Compare and get all the validated relations
            $relations = array_intersect(get_class_methods($relationLoader), $relations);

            foreach ($relations as $relation) {
                if ($this->model instanceof Collection) {
                    $this->model->each(function ($eloq) use ($relationLoader, $relation) {
                        $modelRelations = new $relationLoader($eloq);
                        $eloq = $modelRelations->{$relation}();
                    });
                } else {
                    $modelRelations = new $relationLoader($this->model);
                    $this->model = $modelRelations->{$relation}();
                }
            }
            // $this->model
        }
        if ($this->paginatedData) {
            $this->paginatedData->setCollection($this->model);

            return $this->paginatedData;
        }

        return $this->model;
    }
}
