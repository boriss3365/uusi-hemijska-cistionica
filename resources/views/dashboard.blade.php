@extends('layouts.app')

@section('content')
    <div class="card">
        <h2 style="margin:0 0 10px 0;">Brze akcije</h2>

        <div class="row" style="margin-top:12px;">
            <a class="btn" href="{{ route('orders.create') }}">Nova porudžbina</a>
            <a class="btn btn-secondary" href="{{ route('orders.index') }}">Aktivne porudžbine</a>
        </div>
    </div>

    <div style="height:14px;"></div>

    <div class="card">
        <h3 style="margin:0 0 8px 0;">Aktivne porudžbine</h3>

        @if(isset($activeOrders) && $activeOrders->count() > 0)
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Klijent</th>
                        <th>Status</th>
                        <th>Ukupno</th>
                        <th>Akcija</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activeOrders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>
                                {{ optional($order->client)->first_name }}
                                {{ optional($order->client)->last_name }}
                            </td>
                            <td>{{ $order->status }}</td>
                            <td>{{ number_format((float)$order->total_price, 2) }}</td>
                            <td>
                                <a class="btn" href="{{ route('orders.show', $order) }}">Detalji</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="muted" style="margin-top:10px;">Trenutno nema aktivnih porudžbina.</div>
        @endif
    </div>
@endsection
