<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed the super admin first
        $this->call([
            SuperAdminSeeder::class,
        ]);

        // Seed inventory data
        $this->call([
            CategorySeeder::class,
            BrandSeeder::class,
            SupplierSeeder::class,
            ProductSeeder::class, // Added product seeder
        ]);
    }
}
