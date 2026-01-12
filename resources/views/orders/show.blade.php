@extends('layouts.app')

@section('content')
<div class="card">
    <h2 style="margin:0 0 10px 0;">Detalji porudžbine #{{ $order->id }}</h2>
    <div class="muted">
        Klijent: {{ optional($order->client)->first_name }} {{ optional($order->client)->last_name }} |
        Status: {{ $order->status }} |
        Ukupno: {{ number_format((float)$order->total_price, 2) }} EUR
    </div>

    <table>
        <thead>
            <tr>
                <th>Opis</th>
                <th>Usluga</th>
                <th style="width:110px;">Količina</th>
                <th style="width:140px;">Cijena</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ optional($item->service)->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format((float)$item->line_total, 2) }} EUR</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top:12px;">
        <a class="btn btn-secondary" href="{{ route('orders.index') }}">Nazad</a>
    </div>
</div>
@endsection
