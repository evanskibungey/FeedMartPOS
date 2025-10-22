<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Raw Materials',
                'description' => 'Raw feed ingredients and materials',
                'is_active' => true,
            ],
            [
                'name' => 'Dairy Feed - Twingalick',
                'description' => 'Twingalick dairy feed products for optimal milk production',
                'is_active' => true,
            ],
            [
                'name' => 'Mineral Supplements',
                'description' => 'Mineral licks and supplements for livestock',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
