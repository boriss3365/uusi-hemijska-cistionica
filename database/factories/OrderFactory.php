<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'user_id' => User::factory(),
            'status' => fake()->regexify('[A-Za-z0-9]{30}'),
            'total_price' => fake()->randomFloat(2, 0, 99999999.99),
            'notes' => fake()->text(),
            'received_at' => fake()->dateTime(),
            'completed_at' => fake()->dateTime(),
        ];
    }
}
