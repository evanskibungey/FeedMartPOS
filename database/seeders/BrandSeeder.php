<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Twingalick',
                'description' => 'Premium dairy feed brand for optimal milk production',
                'is_active' => true,
            ],
            [
                'name' => 'Generic',
                'description' => 'Quality raw materials and ingredients',
                'is_active' => true,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
