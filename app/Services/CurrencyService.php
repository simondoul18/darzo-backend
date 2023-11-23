<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyService
{
    public function getDefiniteCurrencies(Request $request)
    {
        $tags = Currency::query();
        $take = 20;

        if ($request->has('search')) {
            $tags->where('name', 'LIKE', '%'.$request->search.'%')->orWhere('code', 'LIKE', '%'.$request->search.'%');
            $take = null;
        }

        if ($take > 0) {
            $tags->take($take);
        }

        return $tags->get();
    }
}
