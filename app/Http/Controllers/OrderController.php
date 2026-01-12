<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $userId = $request->user()->id;

        $orders = Order::with('client')
            ->where('user_id', $userId)
            ->where('status', '!=', 'isporuceno')
            ->orderByDesc('id')
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order, Request $request)
    {
        if ((int) $order->user_id !== (int) $request->user()->id) {
            abort(403);
        }

        $order->load(['client', 'orderItems.service']);

        return view('orders.show', compact('order'));
    }

    public function create()
    {
        $clients = Client::query()->orderBy('last_name')->orderBy('first_name')->get();
        $services = Service::query()->orderBy('name')->get();

        return view('orders.create', compact('clients', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string|max:255',
            'items.*.service_id' => 'required|exists:services,id',
            'items.*.quantity' => 'required|integer|min:1|max:100',
        ]);

        $userId = $request->user()->id;

        DB::transaction(function () use ($validated, $userId) {
            $order = Order::create([
                'client_id' => $validated['client_id'],
                'user_id' => $userId,
                'status' => 'poslato',
                'total_price' => 0,
                'notes' => null,
                'received_at' => now(),
            ]);

            $total = 0;

            foreach ($validated['items'] as $item) {
                $service = Service::findOrFail($item['service_id']);
                $qty = (int) $item['quantity'];
                $unit = (float) $service->price;
                $line = $qty * $unit;

                $order->orderItems()->create([
                    'service_id' => $service->id,
                    'quantity' => $qty,
                    'unit_price' => $unit,
                    'line_total' => $line,
                    'description' => $item['description'],
                ]);

                $total += $line;
            }

            $order->update(['total_price' => $total]);
        });

        return redirect()
            ->route('orders.index')
            ->with('success', 'Porudžbina je sačuvana i dodata u aktivne porudžbine.');
    }

    public function adminIndex()
    {
        $orders = Order::with('client')
            ->orderByDesc('id')
            ->get();

        return view('admin.orders.index', compact('orders'));
    }

    public function createAdmin()
    {
        $clients = Client::query()->orderBy('last_name')->orderBy('first_name')->get();
        $services = Service::query()->orderBy('name')->get();

        return view('orders.create', compact('clients', 'services'));
    }

    public function storeAdmin(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string|max:255',
            'items.*.service_id' => 'required|exists:services,id',
            'items.*.quantity' => 'required|integer|min:1|max:100',
        ]);

        $adminId = $request->user()->id;

        $ownerUserId = Order::where('client_id', $validated['client_id'])
            ->orderByDesc('id')
            ->value('user_id');

        $finalUserId = $ownerUserId ?: $adminId;

        DB::transaction(function () use ($validated, $finalUserId) {
            $order = Order::create([
                'client_id' => $validated['client_id'],
                'user_id' => $finalUserId,
                'status' => 'primljeno',
                'total_price' => 0,
                'notes' => null,
                'received_at' => now(),
            ]);

            $total = 0;

            foreach ($validated['items'] as $item) {
                $service = Service::findOrFail($item['service_id']);
                $qty = (int) $item['quantity'];
                $unit = (float) $service->price;
                $line = $qty * $unit;

                $order->orderItems()->create([
                    'service_id' => $service->id,
                    'quantity' => $qty,
                    'unit_price' => $unit,
                    'line_total' => $line,
                    'description' => $item['description'],
                ]);

                $total += $line;
            }

            $order->update(['total_price' => $total]);
        });

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Porudžbina je dodata.');
    }

    public function edit($orderId)
    {
        $order = Order::with(['client', 'orderItems.service'])->findOrFail($orderId);

        $statuses = ['poslato', 'primljeno', 'u_obradi', 'isporuceno'];
        $clients = Client::query()->orderBy('last_name')->orderBy('first_name')->get();
        $services = Service::query()->orderBy('name')->get();

        $items = $order->orderItems->map(function ($it) {
            return [
                'description' => (string) $it->description,
                'service_id' => (string) $it->service_id,
                'service_name' => (string) ($it->service?->name ?? ''),
                'quantity' => (int) $it->quantity,
                'line_total' => (float) $it->line_total,
            ];
        })->values();

        return view('admin.orders.edit', compact('order', 'statuses', 'clients', 'services', 'items'));
    }

    public function update(Request $request, $orderId)
    {
        $order = Order::findOrFail($orderId);

        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'status' => 'required|in:poslato,primljeno,u_obradi,isporuceno',
            'items' => 'required|array|min:1',
            'items.*.description' => 'required|string|max:255',
            'items.*.service_id' => 'required|exists:services,id',
            'items.*.quantity' => 'required|integer|min:1|max:100',
        ]);

        $adminId = $request->user()->id;

        $ownerUserId = Order::where('client_id', $validated['client_id'])
            ->where('id', '!=', $order->id)
            ->orderByDesc('id')
            ->value('user_id');

        $finalUserId = $ownerUserId ?: ($order->user_id ?: $adminId);

        DB::transaction(function () use ($validated, $order, $finalUserId) {
            $order->update([
                'client_id' => $validated['client_id'],
                'status' => $validated['status'],
                'user_id' => $finalUserId,
            ]);

            $order->orderItems()->delete();

            $total = 0;

            $order->refresh();

            foreach ($validated['items'] as $item) {
                $service = Service::findOrFail($item['service_id']);
                $qty = (int) $item['quantity'];
                $unit = (float) $service->price;
                $line = $qty * $unit;

                $order->orderItems()->create([
                    'service_id' => $service->id,
                    'quantity' => $qty,
                    'unit_price' => $unit,
                    'line_total' => $line,
                    'description' => $item['description'],
                ]);

                $total += $line;
            }

            $order->update(['total_price' => $total]);
        });

        return redirect()
            ->route('admin.orders.edit', $order->id)
            ->with('success', 'Porudžbina je ažurirana.');
    }

    public function destroy($orderId)
    {
        $order = Order::findOrFail($orderId);

        DB::transaction(function () use ($order) {
            $order->orderItems()->delete();
            $order->delete();
        });

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'Porudžbina je obrisana.');
    }
}
