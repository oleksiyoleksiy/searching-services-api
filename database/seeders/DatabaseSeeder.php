<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
            'name' => 'admin'
        ]);


        $provider = Role::create([
            'name' => 'provider'
        ]);

        $userRole = Role::create([
            'name' => 'user'
        ]);

        $adminPermission = Permission::create([
            'permission' => '*'
        ]);

        $admin->permissions()->attach($adminPermission);

        $providerPermissions = [
            'order.view',
            'order.accept',
            'service.manage',
            'message.read',
            'message.reply',
            'schedule.view',
            // 'availability.update',
            // 'document.upload',
            // 'invoice.generate'
        ];


        foreach ($providerPermissions as $permission){
            $p = Permission::create(['permission' => $permission]);
            $provider->permissions()->attach($p);
        }

        $user->roles()->attach($admin);
    }
}
