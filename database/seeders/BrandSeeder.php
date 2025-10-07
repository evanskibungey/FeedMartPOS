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
                'name' => 'Unga Farm Care',
                'description' => 'Premium animal feed products from Unga Limited',
                'is_active' => true,
            ],
            [
                'name' => 'Pembe',
                'description' => 'Quality livestock feed brand',
                'is_active' => true,
            ],
            [
                'name' => 'Kenchic',
                'description' => 'Specialized poultry feeds',
                'is_active' => true,
            ],
            [
                'name' => 'Gold Crown',
                'description' => 'Premium dairy and livestock feeds',
                'is_active' => true,
            ],
            [
                'name' => 'Farmers Choice',
                'description' => 'Affordable quality feeds for farmers',
                'is_active' => true,
            ],
            [
                'name' => 'Nutri Plus',
                'description' => 'Nutritional supplements and vitamins',
                'is_active' => true,
            ],
            [
                'name' => 'Agri-Best',
                'description' => 'Agricultural feed solutions',
                'is_active' => true,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
