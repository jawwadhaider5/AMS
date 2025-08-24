<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'company_name' => 'NDE Offshore',
                'email' => 'abc@example.com',
                'phone_no' => 123456789,
                'country' => 'USA',
                'address' => '123 Main St, City, State',
                'logo' => 'path/to/logo.png',
                'fav_icon' => 'path/to/favicon.ico',
                'meta_title' => 'NDE  - Offshore',
                'meta_description' => 'We provide the best products and services.',
            ],
            // Add more customer data as needed
        ];
        foreach ($customers as $customerData) {
            Setting::create($customerData);
        }
    }
}
