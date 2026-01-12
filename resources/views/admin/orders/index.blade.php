@extends('layouts.app')

@section('content')
<div class="card">
    <h2 style="margin:0 0 12px 0;">Porudžbine</h2>

    <div style="margin-bottom:12px;">
        <a class="btn" href="{{ route('admin.orders.create') }}">Nova porudžbina</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Klijent</th>
                <th>Status</th>
                <th>Ukupno</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->client?->first_name }} {{ $order->client?->last_name }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ number_format((float)$order->total_price, 2) }} EUR</td>
                    <td style="text-align:right;">
                        <a class="btn btn-secondary" href="{{ route('admin.orders.edit', $order) }}">Uredi</a>

                        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Obrisati ovu porudžbinu?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-secondary" type="submit" style="background:#dc2626; color:white;">
                                Obriši
                            </button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="muted">Nema porudžbina.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
