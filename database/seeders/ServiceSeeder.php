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
        'name' => 'Hemijsko ciscenje odijela',
        'description' => 'Komplet (sako + pantalone), standardno hemijsko ciscenje.',
        'price' => 18.00,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Hemijsko ciscenje vjencanice',
        'description' => 'Ciscenje vjencanice (cijena zavisi od materijala i detalja).',
        'price' => 60.00,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Hemijsko ciscenje kaputa',
        'description' => 'Kaput (vuna/mjesavine), standardno hemijsko ciscenje.',
        'price' => 22.00,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Pranje zimske jakne',
        'description' => 'Pranje i susenje zimske jakne.',
        'price' => 12.00,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Pranje dzempera',
        'description' => 'Njezno pranje dzempera (vuna/mjesavine).',
        'price' => 6.00,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Pranje kosulje + peglanje',
        'description' => 'Standardno pranje i peglanje kosulje.',
        'price' => 4.00,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Pranje pantalona + peglanje',
        'description' => 'Standardno pranje i peglanje pantalona.',
        'price' => 5.00,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Pranje posteljine (set)',
        'description' => 'Carsav + jastucnice (set), pranje i susenje.',
        'price' => 10.00,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Pranje stolnjaka',
        'description' => 'Pranje stolnjaka (pamuk/lan), cijena po komadu.',
        'price' => 7.00,
        'created_at' => now(),
        'updated_at' => now(),
    ],
    [
        'name' => 'Pranje jastucnice',
        'description' => 'Pranje jastucnice, cijena po komadu.',
        'price' => 2.50,
        'created_at' => now(),
        'updated_at' => now(),
    ],
        ]);
    }
}
