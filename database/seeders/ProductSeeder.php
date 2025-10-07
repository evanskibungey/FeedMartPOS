<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get categories and brands
        $dairyFeed = Category::where('name', 'Dairy Feed')->first();
        $poultryFeed = Category::where('name', 'Poultry Feed')->first();
        $pigFeed = Category::where('name', 'Pig Feed')->first();
        $sheepGoatFeed = Category::where('name', 'Sheep & Goat Feed')->first();
        $petFood = Category::where('name', 'Pet Food')->first();
        $supplements = Category::where('name', 'Feed Supplements')->first();
        $animalHealth = Category::where('name', 'Animal Health')->first();

        $unga = Brand::where('name', 'Unga Farm Care')->first();
        $pembe = Brand::where('name', 'Pembe')->first();
        $kenchic = Brand::where('name', 'Kenchic')->first();
        $goldCrown = Brand::where('name', 'Gold Crown')->first();
        $farmersChoice = Brand::where('name', 'Farmers Choice')->first();
        $nutriPlus = Brand::where('name', 'Nutri Plus')->first();
        $agriBest = Brand::where('name', 'Agri-Best')->first();

        $products = [
            // Dairy Feed Products
            [
                'name' => 'Dairy Meal 70kg',
                'sku' => 'DM-70',
                'category_id' => $dairyFeed->id,
                'brand_id' => $unga->id,
                'description' => 'High protein dairy feed for lactating cows. Contains 16% protein, balanced minerals and vitamins for optimal milk production.',
                'unit' => '70kg bag',
                'quantity_in_stock' => 45,
                'reorder_level' => 20,
                'price' => 4500.00,
                'wholesale_price' => 4200.00,
                'cost_price' => 3800.00,
                'barcode' => '2589630147852',
                'tax_rate' => 16.00,
                'status' => 'active',
            ],
            [
                'name' => 'Dairy Starter 50kg',
                'sku' => 'DS-50',
                'category_id' => $dairyFeed->id,
                'brand_id' => $goldCrown->id,
                'description' => 'Calf starter feed for young calves. High energy formulation for rapid growth.',
                'unit' => '50kg bag',
                'quantity_in_stock' => 15,
                'reorder_level' => 20,
                'price' => 3200.00,
                'wholesale_price' => 3000.00,
                'cost_price' => 2700.00,
                'barcode' => '2589630147869',
                'tax_rate' => 16.00,
                'status' => 'active',
            ],
            [
                'name' => 'Dairy Premium 70kg',
                'sku' => 'DP-70',
                'category_id' => $dairyFeed->id,
                'brand_id' => $pembe->id,
                'description' => 'Premium dairy concentrate for high-yielding cows. 18% protein with added probiotics.',
                'unit' => '70kg bag',
                'quantity_in_stock' => 8,
                'reorder_level' => 15,
                'price' => 5200.00,
                'wholesale_price' => 4900.00,
                'cost_price' => 4400.00,
                'barcode' => '2589630147876',
                'tax_rate' => 16.00,
                'status' => 'active',
            ],

            // Poultry Feed Products
            [
                'name' => 'Layers Mash 50kg',
                'sku' => 'LM-50',
                'category_id' => $poultryFeed->id,
                'brand_id' => $kenchic->id,
                'description' => 'Complete feed for layers. High calcium for strong eggshells. 16% protein.',
                'unit' => '50kg bag',
                'quantity_in_stock' => 120,
                'reorder_level' => 30,
                'price' => 3400.00,
                'wholesale_price' => 3200.00,
                'cost_price' => 2900.00,
                'barcode' => '2589630147883',
                'tax_rate' => 16.00,
                'status' => 'active',
            ],
            [
                'name' => 'Broiler Starter 50kg',
                'sku' => 'BS-50',
                'category_id' => $poultryFeed->id,
                'brand_id' => $kenchic->id,
                'description' => 'High protein starter for broiler chicks (0-3 weeks). 22% protein.',
                'unit' => '50kg bag',
                'quantity_in_stock' => 85,
                'reorder_level' => 25,
                'price' => 3800.00,
                'wholesale_price' => 3600.00,
                'cost_price' => 3200.00,
                'barcode' => '2589630147890',
                'tax_rate' => 16.00,
                'status' => 'active',
            ],
            [
                'name' => 'Broiler Finisher 50kg',
                'sku' => 'BF-50',
                'category_id' => $poultryFeed->id,
                'brand_id' => $unga->id,
                'description' => 'Complete feed for broilers from 4 weeks to market. 19% protein.',
                'unit' => '50kg bag',
                'quantity_in_stock' => 5,
                'reorder_level' => 25,
                'price' => 3500.00,
                'wholesale_price' => 3300.00,
                'cost_price' => 3000.00,
                'barcode' => '2589630147906',
                'tax_rate' => 16.00,
                'status' => 'active',
            ],
            [
                'name' => 'Kienyeji Growers 25kg',
                'sku' => 'KG-25',
                'category_id' => $poultryFeed->id,
                'brand_id' => $farmersChoice->id,
                'description' => 'Growers mash for indigenous chickens. Natural ingredients.',
                'unit' => '25kg bag',
                'quantity_in_stock' => 0,
                'reorder_level' => 20,
                'price' => 1800.00,
                'wholesale_price' => 1700.00,
                'cost_price' => 1500.00,
                'barcode' => '2589630147913',
                'tax_rate' => 16.00,
                'status' => 'active',
            ],

            // Pig Feed Products
            [
                'name' => 'Pig Growers 70kg',
                'sku' => 'PG-70',
                'category_id' => $pigFeed->id,
                'brand_id' => $pembe->id,
                'description' => 'Complete feed for growing pigs (20-60kg). Balanced nutrition for optimal growth.',
                'unit' => '70kg bag',
                'quantity_in_stock' => 32,
                'reorder_level' => 15,
                'price' => 4200.00,
                'wholesale_price' => 4000.00,
                'cost_price' => 3600.00,
                'barcode' => '2589630147920',
                'tax_rate' => 16.00,
                'status' => 'active',
            ],
            [
                'name' => 'Sow & Weaner 50kg',
                'sku' => 'SW-50',
                'category_id' => $pigFeed->id,
                'brand_id' => $goldCrown->id,
                'description' => 'Special feed for lactating sows and weaner piglets. High energy and protein.',
                'unit' => '50kg bag',
                'quantity_in_stock' => 18,
                'reorder_level' => 12,
                'price' => 3600.00,
                'wholesale_price' => 3400.00,
                'cost_price' => 3100.00,
                'barcode' => '2589630147937',
                'tax_rate' => 16.00,
                'status' => 'active',
            ],

            // Sheep & Goat Feed
            [
                'name' => 'Goat Pellets 50kg',
                'sku' => 'GP-50',
                'category_id' => $sheepGoatFeed->id,
                'brand_id' => $farmersChoice->id,
                'description' => 'Pelleted feed for dairy goats. High protein for milk production.',
                'unit' => '50kg bag',
                'quantity_in_stock' => 28,
                'reorder_level' => 15,
                'price' => 3000.00,
                'wholesale_price' => 2850.00,
                'cost_price' => 2500.00,
                'barcode' => '2589630147944',
                'tax_rate' => 16.00,
                'status' => 'active',
            ],
            [
                'name' => 'Sheep Fattening 70kg',
                'sku' => 'SF-70',
                'category_id' => $sheepGoatFeed->id,
                'brand_id' => $agriBest->id,
                'description' => 'High energy feed for fattening sheep. Ready for market in 90 days.',
                'unit' => '70kg bag',
                'quantity_in_stock' => 12,
                'reorder_level' => 10,
                'price' => 3800.00,
                'wholesale_price' => 3600.00,
                'cost_price' => 3200.00,
                'barcode' => '2589630147951',
                'tax_rate' => 16.00,
                'status' => 'active',
            ],

            // Pet Food
            [
                'name' => 'Dog Food Premium 10kg',
                'sku' => 'DF-10',
                'category_id' => $petFood->id,
                'brand_id' => $nutriPlus->id,
                'description' => 'Complete nutrition for adult dogs. Chicken and rice formula.',
                'unit' => '10kg bag',
                'quantity_in_stock' => 45,
                'reorder_level' => 20,
                'price' => 2500.00,
                'wholesale_price' => 2300.00,
                'cost_price' => 2000.00,
                'barcode' => '2589630147968',
                'tax_rate' => 16.00,
                'status' => 'active',
            ],
            [
                'name' => 'Cat Food Adult 5kg',
                'sku' => 'CF-05',
                'category_id' => $petFood->id,
                'brand_id' => $nutriPlus->id,
                'description' => 'Balanced nutrition for adult cats. Fish and chicken flavour.',
                'unit' => '5kg bag',
                'quantity_in_stock' => 22,
                'reorder_level' => 15,
                'price' => 1500.00,
                'wholesale_price' => 1400.00,
                'cost_price' => 1200.00,
                'barcode' => '2589630147975',
                'tax_rate' => 16.00,
                'status' => 'active',
            ],

            // Feed Supplements
            [
                'name' => 'Mineral Block 2kg',
                'sku' => 'MB-02',
                'category_id' => $supplements->id,
                'brand_id' => $nutriPlus->id,
                'description' => 'Mineral lick block for cattle, sheep and goats. Contains essential minerals.',
                'unit' => '2kg block',
                'quantity_in_stock' => 65,
                'reorder_level' => 30,
                'price' => 350.00,
                'wholesale_price' => 320.00,
                'cost_price' => 280.00,
                'barcode' => '2589630147982',
                'tax_rate' => 16.00,
                'status' => 'active',
            ],
            [
                'name' => 'Poultry Vitamin Premix 1kg',
                'sku' => 'PV-01',
                'category_id' => $supplements->id,
                'brand_id' => $nutriPlus->id,
                'description' => 'Complete vitamin and mineral premix for poultry. Add to feed or water.',
                'unit' => '1kg packet',
                'quantity_in_stock' => 88,
                'reorder_level' => 40,
                'price' => 850.00,
                'wholesale_price' => 800.00,
                'cost_price' => 700.00,
                'barcode' => '2589630147999',
                'tax_rate' => 16.00,
                'status' => 'active',
            ],
            [
                'name' => 'Cattle Growth Booster 500g',
                'sku' => 'CGB-500',
                'category_id' => $supplements->id,
                'brand_id' => $agriBest->id,
                'description' => 'Growth hormone booster for young cattle. Natural ingredients.',
                'unit' => '500g bottle',
                'quantity_in_stock' => 3,
                'reorder_level' => 10,
                'price' => 1200.00,
                'wholesale_price' => 1100.00,
                'cost_price' => 950.00,
                'barcode' => '2589630148002',
                'tax_rate' => 16.00,
                'status' => 'active',
            ],

            // Animal Health Products
            [
                'name' => 'Dewormer Cattle 250ml',
                'sku' => 'DC-250',
                'category_id' => $animalHealth->id,
                'brand_id' => $agriBest->id,
                'description' => 'Broad spectrum dewormer for cattle. Treats all internal parasites.',
                'unit' => '250ml bottle',
                'quantity_in_stock' => 42,
                'reorder_level' => 20,
                'price' => 1800.00,
                'wholesale_price' => 1700.00,
                'cost_price' => 1500.00,
                'barcode' => '2589630148019',
                'tax_rate' => 16.00,
                'status' => 'active',
            ],
            [
                'name' => 'Poultry Antibiotics 100ml',
                'sku' => 'PA-100',
                'category_id' => $animalHealth->id,
                'brand_id' => $nutriPlus->id,
                'description' => 'Water soluble antibiotics for poultry respiratory diseases.',
                'unit' => '100ml bottle',
                'quantity_in_stock' => 0,
                'reorder_level' => 15,
                'price' => 950.00,
                'wholesale_price' => 900.00,
                'cost_price' => 800.00,
                'barcode' => '2589630148026',
                'tax_rate' => 16.00,
                'status' => 'active',
            ],
            [
                'name' => 'Livestock Spray 500ml',
                'sku' => 'LS-500',
                'category_id' => $animalHealth->id,
                'brand_id' => $agriBest->id,
                'description' => 'Tick and fly spray for all livestock. Long-lasting protection.',
                'unit' => '500ml bottle',
                'quantity_in_stock' => 35,
                'reorder_level' => 25,
                'price' => 750.00,
                'wholesale_price' => 700.00,
                'cost_price' => 620.00,
                'barcode' => '2589630148033',
                'tax_rate' => 16.00,
                'status' => 'active',
            ],
            [
                'name' => 'Hoof Care Solution 1L',
                'sku' => 'HCS-1L',
                'category_id' => $animalHealth->id,
                'brand_id' => $goldCrown->id,
                'description' => 'Hoof treatment and prevention solution for cattle and goats.',
                'unit' => '1 liter bottle',
                'quantity_in_stock' => 18,
                'reorder_level' => 12,
                'price' => 1500.00,
                'wholesale_price' => 1400.00,
                'cost_price' => 1250.00,
                'barcode' => '2589630148040',
                'tax_rate' => 16.00,
                'status' => 'active',
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        $this->command->info('20 products seeded successfully!');
        $this->command->info('Stock Status:');
        $this->command->info('- In Stock (above reorder): ' . Product::where('quantity_in_stock', '>', 20)->count());
        $this->command->info('- Low Stock (at/below reorder): ' . Product::lowStock()->count());
        $this->command->info('- Out of Stock: ' . Product::outOfStock()->count());
    }
}
