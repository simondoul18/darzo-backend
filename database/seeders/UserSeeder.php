<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user1 = (new User)->create([
            'uuid' => Str::uuid(),
            'name' => 'SuperAdmin',
            'email' => 'superadmin@test.com',
            'password' => '12345678',
        ]);
        $user1->assignRole('Super Admin');

        $user1 = (new User)->create([
            'uuid' => Str::uuid(),
            'name' => 'supplier',
            'email' => 'supplier@test.com',
            'password' => '12345678',
        ]);
        $user1->assignRole('Supplier');

        $user1 = (new User)->create([
            'uuid' => Str::uuid(),
            'name' => 'producer',
            'email' => 'producer@test.com',
            'password' => '12345678',
        ]);
        $user1->assignRole('Producer');

        $user1 = (new User)->create([
            'uuid' => Str::uuid(),
            'name' => 'customer',
            'email' => 'customer@test.com',
            'password' => '12345678',
        ]);
        $user1->assignRole('Customer');
    }
}
