<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@gmail.com',
        ]);

        $admin = Role::create([
            'name' => 'admin',
            'guard_name' => 'api'
        ]);


        $provider = Role::create([
            'name' => 'provider',
            'guard_name' => 'api'
        ]);

        $userRole = Role::create([
            'name' => 'user',
            'guard_name' => 'api'
        ]);

        $adminPermission = Permission::create([
            'name' => 'admin',
            'guard_name' => 'api'
        ]);
        $providerPermission = Permission::create([
            'name' => 'provider',
            'guard_name' => 'api'
        ]);

        $admin->permissions()->attach($adminPermission);

        $provider->permissions()->attach($providerPermission);

        $user->roles()->attach($admin);
    }
}
