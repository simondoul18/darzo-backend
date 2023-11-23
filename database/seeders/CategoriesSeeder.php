<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category = new ProductCategory;

        $category->delete();

        $category->insert([
            ['name' => 'Verandas', 'uuid' => Str::uuid()],
            ['name' => 'Bioclimatics', 'uuid' => Str::uuid()],
            ['name' => 'Windows', 'uuid' => Str::uuid()],
            ['name' => 'Porche', 'uuid' => Str::uuid()],
            ['name' => 'Zonwering', 'uuid' => Str::uuid()],
            ['name' => 'Doors', 'uuid' => Str::uuid()],
        ]);
    }
}
