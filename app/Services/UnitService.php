<?php

namespace App\Services;

use App\Models\Unit;
use Illuminate\Http\Request;

class UnitService
{
    public function getDefiniteUnits(Request $request)
    {
        $units = Unit::query();
        $take = 10;

        if ($request->has('search')) {
            $units->where('name', 'LIKE', '%'.$request->search.'%');
            $take = null;
        }

        if ($take > 0) {
            $units->take($take);
        }

        return $units->get();
    }
}
