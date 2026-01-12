@extends('layouts.app')

@section('content')
<div class="card" style="max-width:800px;">
    <h2 style="margin:0 0 12px 0;">Uredi porudžbinu #{{ $order->id }}</h2>

    <div class="muted" style="margin-bottom:14px;">
        Klijent: {{ $order->client->first_name }} {{ $order->client->last_name }} ({{ $order->client->phone }})
    </div>

    <form method="POST" action="{{ route('admin.orders.update', $order) }}">
        @csrf
        @method('PUT')

        <div style="margin-bottom:18px;">
            <label style="display:block; margin-bottom:6px;">Status</label>
            <select name="status" required>
                @foreach($statuses as $st)
                    <option value="{{ $st }}" @selected($order->status === $st)>{{ $st }}</option>
                @endforeach
            </select>
        </div>

        <div class="row" style="gap:10px;">
            <button class="btn" type="submit">Sačuvaj</button>
            <a class="btn btn-secondary" href="{{ url('/admin/orders') }}">Nazad</a>
        </div>
    </form>
</div>
@endsection
