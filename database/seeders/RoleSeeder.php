<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Administrator',
                'slug' => 'admin',
                'description' => 'Administrator with full system access',
            ],
            [
                'name' => 'Project Manager',
                'slug' => 'project-manager',
                'description' => 'Can manage projects and view reports',
            ],
            [
                'name' => 'Accountant',
                'slug' => 'accountant',
                'description' => 'Can manage billings, customers, and generate reports',
            ],
            [
                'name' => 'Inventory Staff',
                'slug' => 'inventory-staff',
                'description' => 'Can manage inventory and suppliers',
            ],
            [
                'name' => 'Supplier',
                'slug' => 'supplier',
                'description' => 'External supplier with limited access',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
