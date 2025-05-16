<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Service;
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
                'address' => '123 test St',
                'postal_code' => '88000',
                'phone_number' => '+380999999999'
            ]);

            $provider = User::factory()->create([
                'name' => 'provider',
                'email' => 'provider@gmail.com',
                'address' => '123 provider St, Uzhhorod',
                'postal_code' => '88000',
                'phone_number' => '+380111111111'
            ]);

            $admin = Role::create([
                'name' => 'admin',
                'guard_name' => 'api'
            ]);


            $providerRole = Role::create([
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

            $providerRole->permissions()->attach($providerPermission);

            $user->roles()->attach($admin);

            $categories = [
                'Hair & Beauty',
                'Home Repair',
                'Education',
                'Art & Design',
                'Automotive',
                'Home Services',
                'Health & Wellness',
                'Food & Drink',
                'Personal Shopping',
                'Music Lessons',
                'IT'
            ];


            $company = $provider->company()->create([
                'name' => 'Test LLC',
                'years_of_experience' => 5,
            ]);


            $company->availabilities()->create([
                'day' => 'Monday',
                'start' => '8:00',
                'end' => '18:00'
            ]);

            $company->availabilities()->create([
                'day' => 'Tuesday',
                'start' => '8:00',
                'end' => '18:00'
            ]);

            $company->availabilities()->create([
                'day' => 'Wednesday',
                'start' => '8:00',
                'end' => '18:00'
            ]);

            $createdCategories = [];

            foreach ($categories as $category) {
                $created = Category::create([
                    'name' => $category
                ]);
                $createdCategories[] = $created->id;
            }

            $company->categories()->sync(array_slice($createdCategories, 0, 3));

            $company->services()->create([
                'name' => 'Car checkout',
                'description' => 'full checkout of your vehicle',
                'price' => '100'
            ]);

            $company->services()->create([
                'name' => 'Car software update',
                'description' => 'update your car software',
                'price' => '50'
            ]);

            $user->reviews()->create([
                'company_id' => $company->id,
                'content' => 'Great service! Very professional and on time. Would definitely recommend.',
                'rating' => 5
            ]);

            $user->reviews()->create([
                'company_id' => $company->id,
                'content' => 'Good experience overall. Service was as described and reasonably priced.',
                'rating' => 4
            ]);

            $company->files()->create([
                'path' => '/images/car-checkout.png',
                'type' => 'preview'
            ]);
        });
    }
}
