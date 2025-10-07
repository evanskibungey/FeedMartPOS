<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;

class SupplierSeeder extends Seeder
{
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Unga Limited',
                'contact_name' => 'John Kamau',
                'phone' => '0712345678',
                'email' => 'orders@unga.co.ke',
                'address' => 'Commercial Street',
                'city' => 'Nairobi',
                'payment_terms' => 'Net 30 days',
                'notes' => 'Main supplier for Unga branded products',
                'is_active' => true,
            ],
            [
                'name' => 'Pembe Flour Mills',
                'contact_name' => 'Mary Wanjiku',
                'phone' => '0723456789',
                'email' => 'sales@pembe.co.ke',
                'address' => 'Industrial Area',
                'city' => 'Nairobi',
                'payment_terms' => 'Net 30 days',
                'notes' => 'Supplier for Pembe brand feeds',
                'is_active' => true,
            ],
            [
                'name' => 'Kenchic Limited',
                'contact_name' => 'Peter Ochieng',
                'phone' => '0734567890',
                'email' => 'info@kenchic.com',
                'address' => 'Ruiru',
                'city' => 'Kiambu',
                'payment_terms' => 'Net 14 days',
                'notes' => 'Poultry feed specialist',
                'is_active' => true,
            ],
            [
                'name' => 'East Africa Feeds',
                'contact_name' => 'Sarah Muthoni',
                'phone' => '0745678901',
                'email' => 'sales@eafeeds.co.ke',
                'address' => 'Thika Road',
                'city' => 'Nairobi',
                'payment_terms' => 'Net 30 days',
                'notes' => 'Multiple brand distributor',
                'is_active' => true,
            ],
            [
                'name' => 'AgriVet Supplies',
                'contact_name' => 'James Kiprop',
                'phone' => '0756789012',
                'email' => 'orders@agrivet.co.ke',
                'address' => 'Moi Avenue',
                'city' => 'Eldoret',
                'payment_terms' => 'Cash on delivery',
                'notes' => 'Health products and supplements',
                'is_active' => true,
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
