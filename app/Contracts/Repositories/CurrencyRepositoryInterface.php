<?php

namespace App\Contracts\Repositories;

use App\Models\Currency;
use Illuminate\Database\Eloquent\Model;

interface CurrencyRepositoryInterface
{
    public function __construct(Model $model);

    public function getCurrency(): ?Currency;
}
