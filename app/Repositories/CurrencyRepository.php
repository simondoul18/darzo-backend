<?php

namespace App\Repositories;

use App\Contracts\Repositories\CurrencyRepositoryInterface;
use App\Models\Currency;
use Illuminate\Database\Eloquent\Model;

class CurrencyRepository implements CurrencyRepositoryInterface
{
    private Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getCurrency(): ?Currency
    {
        if ($this->model->currency) {
            return $this->model->currency;
        }

        return null;
    }
}
