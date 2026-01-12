<?php

namespace Tests\Feature;

use App\Models\Client;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminUpdatesOrderStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_update_order_status_and_items(): void
    {
        $admin = User::factory()->create();
        $client = Client::factory()->create();
        $service = Service::factory()->create(['price' => 5.00]);

        $order = Order::create([
            'client_id' => $client->id,
            'user_id' => $admin->id,
            'status' => 'primljeno',
            'total_price' => 0,
            'received_at' => now(),
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'service_id' => $service->id,
            'quantity' => 1,
            'unit_price' => 5.00,
            'line_total' => 5.00,
            'description' => 'Pantalone',
        ]);

        $this->withoutMiddleware();

        $payload = [
            'client_id' => $client->id,
            'status' => 'u_obradi',
            'items' => [
                [
                    'description' => 'Pantalone',
                    'service_id' => $service->id,
                    'quantity' => 3,
                ],
            ],
        ];

        $response = $this->actingAs($admin)->put(route('admin.orders.update', $order), $payload);

        $response->assertRedirect(route('admin.orders.edit', $order));

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => 'u_obradi',
        ]);

        $this->assertDatabaseHas('order_items', [
            'order_id' => $order->id,
            'service_id' => $service->id,
            'quantity' => 3,
            'description' => 'Pantalone',
        ]);
    }
}
