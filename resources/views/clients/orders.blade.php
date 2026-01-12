@extends('layouts.app')

@section('content')
<div class="card">
    <div class="row" style="justify-content:space-between; align-items:center; margin-bottom:12px;">
        <h2 style="margin:0;">Porudžbine — {{ $client->first_name }} {{ $client->last_name }}</h2>
        <a class="btn btn-secondary" href="{{ route('admin.clients.index') }}">Nazad</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Status</th>
                <th>Ukupno</th>
                <th>Datum</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ number_format((float)$order->total_price, 2) }} EUR</td>
                    <td>{{ optional($order->created_at)->format('d.m.Y H:i') }}</td>
                    <td style="text-align:right;">
                        <a class="btn btn-secondary" href="{{ route('admin.orders.edit', $order) }}">Uredi</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="muted">Nema porudžbina za ovog klijenta.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
