<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = new Unit;

        $units->delete();

        $units->insert([
            ['name' => 'Kilo gram', 'unit' => 'kg'],
            ['name' => 'Meter', 'unit' => 'm'],
            ['name' => 'Cubic meter', 'unit' => 'l3'],
            ['name' => 'Piece', 'unit' => 'p'],
            ['name' => 'Gram', 'unit' => 'g'],
            ['name' => 'Milimeter', 'unit' => 'mm'],
            ['name' => 'Centimeter', 'unit' => 'cm'],
            ['name' => 'Mile', 'unit' => 'mi'],
            ['name' => 'Unit 1', 'unit' => 'u1'],
            ['name' => 'Unit 2', 'unit' => 'u2'],
            ['name' => 'Unit 3', 'unit' => 'u3'],
        ]);
    }
}
