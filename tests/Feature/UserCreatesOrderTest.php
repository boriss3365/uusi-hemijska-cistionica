<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserCreatesOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_create_order_with_items(): void
    {
        $user = User::factory()->create();
        $client = Client::factory()->create();
        $service = Service::factory()->create(['price' => 10.00]);

        $payload = [
            'client_id' => $client->id,
            'items' => [
                [
                    'description' => 'Kosulja',
                    'service_id' => $service->id,
                    'quantity' => 2,
                ],
            ],
        ];

        $response = $this->actingAs($user)->post(route('orders.store'), $payload);

        $response->assertRedirect(route('orders.index'));

        $this->assertDatabaseHas('orders', [
            'client_id' => $client->id,
            'user_id' => $user->id,
            'status' => 'poslato',
        ]);

        $this->assertDatabaseHas('order_items', [
            'service_id' => $service->id,
            'quantity' => 2,
            'description' => 'Kosulja',
        ]);
    }
}
