<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'position' => 'admin',
        ]);

        $admin->roles()->attach(Role::where('slug', 'admin')->first());

        // Create a project manager
        $manager = User::create([
            'name' => 'Project Manager',
            'email' => 'manager@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'position' => 'project-manager',
        ]);

        $manager->roles()->attach(Role::where('slug', 'project-manager')->first());

        // Create an accountant
        $accountant = User::create([
            'name' => 'Accountant User',
            'email' => 'accountant@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'position' => 'accountant',
        ]);

        $accountant->roles()->attach(Role::where('slug', 'accountant')->first());

        // Create an inventory staff
        $inventory = User::create([
            'name' => 'Inventory Staff',
            'email' => 'inventory@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'position' => 'inventory-staff',
        ]);

        $inventory->roles()->attach(Role::where('slug', 'inventory-staff')->first());

        // Create a supplier
        $supplier = User::create([
            'name' => 'Supplier User',
            'email' => 'supplier@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'position' => 'supplier',
        ]);

        $supplier->roles()->attach(Role::where('slug', 'supplier')->first());
    }
}
