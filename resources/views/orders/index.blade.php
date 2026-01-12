@extends('layouts.app')

@section('content')
<div class="card">
    <h2 style="margin:0 0 10px 0;">Aktivne porudžbine</h2>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Klijent</th>
                <th>Status</th>
                <th>Ukupno</th>
                <th>Opis</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->id }}</td>
                    <td>{{ optional($order->client)->first_name }} {{ optional($order->client)->last_name }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ number_format((float)$order->total_price, 2) }} EUR</td>
                    <td><a class="btn" href="{{ route('orders.show', $order) }}">Detalji</a></td>
                </tr>
            @endforeach

            @if($orders->count() === 0)
                <tr><td colspan="5">Nema porudžbina.</td></tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
