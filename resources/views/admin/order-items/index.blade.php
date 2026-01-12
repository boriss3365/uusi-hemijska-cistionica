@extends('layouts.app')

@section('content')
<div class="card">
    <div class="row" style="justify-content:space-between; align-items:center; gap:12px;">
        <h2 style="margin:0;">Stavke porudžbina</h2>
        <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">Nazad</a>
    </div>

    @if(session('success'))
        <div class="card" style="background:#ecfdf5; border:1px solid #a7f3d0; margin-top:12px;">
            {{ session('success') }}
        </div>
    @endif

    <table style="margin-top:12px;">
        <thead>
            <tr>
                <th>#</th>
                <th>Porudžbina</th>
                <th>Klijent</th>
                <th>Usluga</th>
                <th style="width:110px;">Količina</th>
                <th style="width:140px;">Jedinična</th>
                <th style="width:140px;">Ukupno</th>
                <th>Opis</th>
                <th style="width:220px;"></th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $it)
                <tr>
                    <td>{{ $it->id }}</td>
                    <td>#{{ $it->order_id }}</td>
                    <td>
                        {{ $it->order?->client?->first_name }} {{ $it->order?->client?->last_name }}
                    </td>
                    <td>{{ $it->service?->name }}</td>
                    <td>{{ $it->quantity }}</td>
                    <td>{{ number_format((float)$it->unit_price, 2) }} EUR</td>
                    <td>{{ number_format((float)$it->line_total, 2) }} EUR</td>
                    <td>{{ $it->description }}</td>
                    <td style="text-align:right; display:flex; justify-content:flex-end; gap:8px; align-items:center;">
                        <a class="btn btn-secondary" href="{{ route('admin.order-items.edit', $it) }}">Uredi</a>

                        <form method="POST" action="{{ route('admin.order-items.destroy', $it) }}" onsubmit="return confirm('Obrisati ovu stavku?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-secondary" type="submit" style="background:#dc2626; color:white;">
                                Obriši
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="muted">Nema stavki.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
