<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create default admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password123'),
            'position' => 'admin',
        ]);

        // Create additional role-based users
        DB::table('users')->insert([
            'name' => 'Project Manager',
            'email' => 'pm@gmail.com',
            'password' => Hash::make('password123'),
            'position' => 'project-manager',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Accountant',
            'email' => 'accountant@gmail.com',
            'password' => Hash::make('password123'),
            'position' => 'accountant',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Inventory Staff',
            'email' => 'inventory@gmail.com',
            'password' => Hash::make('password123'),
            'position' => 'inventory-staff',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => 'Supplier',
            'email' => 'supplier@gmail.com',
            'password' => Hash::make('password123'),
            'position' => 'supplier',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
