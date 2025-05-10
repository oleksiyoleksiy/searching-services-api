<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::transaction(function () {

            $user = User::factory()->create([
                'name' => 'Test User',
                'email' => 'test@gmail.com',
                'phone_number' => '+380999999999'
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

            $categories = [
                'plumbing',
                'electrical',
                'cleaning',
                'landscaping',
                'painting',
                'hvac',
                'security',
                'it',
                'construction',
                'delivery'
            ];

            foreach ($categories as $category) {
                Category::create([
                    'name' => $category
                ]);
            }
        });
    }
}
