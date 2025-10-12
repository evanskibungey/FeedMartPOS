<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'system_name',
                'value' => 'FeedMart POS',
                'type' => 'string',
                'description' => 'The name of the system displayed across all portals',
            ],
            [
                'key' => 'system_currency',
                'value' => 'KES',
                'type' => 'string',
                'description' => 'Default currency for the system',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('System settings seeded successfully!');
    }
}
