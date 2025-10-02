<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if super admin already exists
        $superAdmin = User::where('role', 'super_admin')->first();

        if (!$superAdmin) {
            User::create([
                'name' => 'Super Administrator',
                'email' => 'admin@feedmart.com',
                'phone' => '+254700000000',
                'password' => Hash::make('Admin@123'),
                'role' => 'super_admin',
                'is_active' => true,
                'email_verified_at' => now(),
            ]);

            $this->command->info('Super Admin created successfully!');
            $this->command->info('Email: admin@feedmart.com');
            $this->command->info('Phone: +254700000000');
            $this->command->info('Password: Admin@123');
            $this->command->warn('Please change the password after first login!');
        } else {
            $this->command->info('Super Admin already exists.');
        }
    }
}
