<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        (new Role)->delete();

        $roles = [[
            'name' => 'Super Admin',
            'guard_name' => 'api',
        ], [
            'name' => 'Supplier',
            'guard_name' => 'api',
        ], [
            'name' => 'Producer',
            'guard_name' => 'api',
        ], [
            'name' => 'Customer',
            'guard_name' => 'api',
        ]];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
