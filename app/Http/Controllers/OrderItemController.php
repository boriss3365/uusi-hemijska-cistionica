<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Service;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index()
    {
        $items = OrderItem::query()
            ->with(['order.client', 'service'])
            ->orderByDesc('id')
            ->get();

        return view('admin.order-items.index', compact('items'));
    }

    public function edit(OrderItem $order_item)
    {
        $order_item->load(['order.client', 'service']);
        $services = Service::query()->orderBy('name')->get();

        return view('admin.order-items.edit', [
            'item' => $order_item,
            'services' => $services,
        ]);
    }

    public function update(Request $request, OrderItem $order_item)
    {
        $validated = $request->validate([
            'description' => 'required|string|max:255',
            'service_id' => 'required|exists:services,id',
            'quantity' => 'required|integer|min:1|max:100',
        ]);

        $service = Service::findOrFail($validated['service_id']);
        $qty = (int) $validated['quantity'];
        $unit = (float) $service->price;
        $line = $qty * $unit;

        $order_item->update([
            'description' => $validated['description'],
            'service_id' => (int) $validated['service_id'],
            'quantity' => $qty,
            'unit_price' => $unit,
            'line_total' => $line,
        ]);

        $order = $order_item->order()->with('orderItems')->first();
        if ($order) {
            $total = $order->orderItems->sum('line_total');
            $order->update(['total_price' => $total]);
        }

        return redirect()
            ->route('admin.order-items.index')
            ->with('success', 'Stavka porudžbine je ažurirana.');
    }

    public function destroy(OrderItem $order_item)
    {
        $order = $order_item->order()->with('orderItems')->first();

        $order_item->delete();

        if ($order) {
            $order->refresh();
            $total = $order->orderItems()->sum('line_total');
            $order->update(['total_price' => $total]);
        }

        return redirect()
            ->route('admin.order-items.index')
            ->with('success', 'Stavka porudžbine je obrisana.');
    }
}
