<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::query()->insert([
            [
                'name' => 'Pranje kosulje',
                'description' => 'Standardno pranje i peglanje.',
                'price' => 3.50,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Hemijsko ciscenje odijela',
                'description' => 'Hemijsko ciscenje kompleta.',
                'price' => 15.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pranje jakne',
                'description' => 'Pranje i susenje jakne.',
                'price' => 8.00,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
