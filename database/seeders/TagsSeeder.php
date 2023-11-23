<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = new Tag;
        $tags->delete();

        $tags->insert([
            ['name' => 'widows', 'uuid' => Str::uuid()],
            ['name' => 'doors', 'uuid' => Str::uuid()],
            ['name' => 'door manufacturing', 'uuid' => Str::uuid()],
            ['name' => 'veranda order', 'uuid' => Str::uuid()],
            ['name' => 'bioclimatic', 'uuid' => Str::uuid()],
            ['name' => 'veranda europe', 'uuid' => Str::uuid()],
            ['name' => 'tag 1', 'uuid' => Str::uuid()],
            ['name' => 'tag 2', 'uuid' => Str::uuid()],
            ['name' => 'tag 3', 'uuid' => Str::uuid()],
        ]);
    }
}
