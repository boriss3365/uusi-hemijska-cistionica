<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminClientController extends Controller
{
    public function index()
    {
        $clients = Client::query()
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'phone'      => 'nullable|string|max:30',
            'email'      => 'nullable|email|max:150',
            'address'    => 'nullable|string|max:255',
        ]);

        Client::create($validated);

        return redirect()
            ->route('admin.clients.index')
            ->with('success', 'Klijent je uspješno dodat.');
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'phone'      => 'nullable|string|max:30',
            'email'      => 'nullable|email|max:150',
            'address'    => 'nullable|string|max:255',
        ]);

        $client->update($validated);

        return redirect()
            ->route('admin.clients.index')
            ->with('success', 'Podaci o klijentu su ažurirani.');
    }

    public function destroy(Client $client)
    {
        $client->delete();

        return redirect()
            ->route('admin.clients.index')
            ->with('success', 'Klijent je obrisan.');
    }

    public function orders(Client $client)
    {
        $orders = Order::query()
            ->with('client')
            ->where('client_id', $client->id)
            ->orderByDesc('id')
            ->get();

        return view('clients.orders', compact('client', 'orders'));
    }
}
