<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $client = Client::query()->first();
        $user = User::query()->first();
        $service1 = Service::query()->first();
        $service2 = Service::query()->skip(1)->first();

        if (! $client || ! $user || ! $service1 || ! $service2) {
            return;
        }

        $order = Order::query()->create([
            'client_id' => $client->id,
            'user_id' => $user->id,
            'status' => 'primljeno',
            'total_price' => 0,
            'notes' => 'Test porudzbina iz seedera.',
            'received_at' => now(),
        ]);

        $items = [
            [
                'order_id' => $order->id,
                'service_id' => $service1->id,
                'quantity' => 2,
                'unit_price' => $service1->price,
                'line_total' => 2 * $service1->price,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'order_id' => $order->id,
                'service_id' => $service2->id,
                'quantity' => 1,
                'unit_price' => $service2->price,
                'line_total' => 1 * $service2->price,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        OrderItem::query()->insert($items);

        $total = collect($items)->sum('line_total');

        $order->update([
            'total_price' => $total,
        ]);
    }
}
