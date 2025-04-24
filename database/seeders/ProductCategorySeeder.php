<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Cement',
                'description' => 'All types of cement products',
            ],
            [
                'name' => 'Steel',
                'description' => 'Steel bars, sheets, and related products',
            ],
            [
                'name' => 'Wood',
                'description' => 'Lumber, plywood, and wooden materials',
            ],
            [
                'name' => 'Electrical',
                'description' => 'All electrical materials and supplies',
            ],
            [
                'name' => 'Plumbing',
                'description' => 'Pipes, fittings, and plumbing supplies',
            ],
            [
                'name' => 'Paint',
                'description' => 'Paints, primers, and painting supplies',
            ],
            [
                'name' => 'Tools',
                'description' => 'Hand tools, power tools, and equipment',
            ],
            [
                'name' => 'Hardware',
                'description' => 'Fasteners, nails, screws, and general hardware',
            ],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}
