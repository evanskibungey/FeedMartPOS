<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        // Supplier data removed - to be added manually through admin panel
        $this->command->info('⚠ SupplierSeeder: No suppliers seeded. Add suppliers via admin panel.');
    }
}
