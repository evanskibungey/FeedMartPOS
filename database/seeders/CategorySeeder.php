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
                'name' => 'Dairy Feed',
                'description' => 'Feed products for dairy cattle',
                'is_active' => true,
            ],
            [
                'name' => 'Poultry Feed',
                'description' => 'Feed products for chickens and other poultry',
                'is_active' => true,
            ],
            [
                'name' => 'Pig Feed',
                'description' => 'Feed products for pigs',
                'is_active' => true,
            ],
            [
                'name' => 'Sheep & Goat Feed',
                'description' => 'Feed products for sheep and goats',
                'is_active' => true,
            ],
            [
                'name' => 'Pet Food',
                'description' => 'Feed products for pets',
                'is_active' => true,
            ],
            [
                'name' => 'Feed Supplements',
                'description' => 'Vitamin and mineral supplements for animals',
                'is_active' => true,
            ],
            [
                'name' => 'Animal Health',
                'description' => 'Veterinary and health products',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
