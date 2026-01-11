<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        Client::query()->insert([
            [
                'first_name' => 'Marko',
                'last_name' => 'Markovic',
                'phone' => '+38267111222',
                'email' => 'marko@example.com',
                'address' => 'Njegoseva 1, Podgorica',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Jelena',
                'last_name' => 'Jovanovic',
                'phone' => '+38269123456',
                'email' => 'jelena@example.com',
                'address' => 'Bokeška 10, Tivat',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
