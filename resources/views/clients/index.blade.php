@extends('layouts.app')

@section('content')
<div class="card">
    <div class="row" style="justify-content:space-between; align-items:center; gap:12px;">
        <h2 style="margin:0;">Klijenti</h2>
        <a class="btn" href="{{ route('admin.clients.create') }}" style="background:#2563eb;">Dodaj novog klijenta</a>
    </div>

    @if(session('success'))
        <div class="card" style="background:#ecfdf5; border:1px solid #a7f3d0; margin-top:12px;">
            {{ session('success') }}
        </div>
    @endif

    <table style="margin-top:12px;">
        <thead>
            <tr>
                <th>Ime</th>
                <th>Prezime</th>
                <th>Telefon</th>
                <th>Email</th>
                <th>Adresa</th>
                <th style="width:340px;"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($clients as $client)
                <tr>
                    <td>{{ $client->first_name }}</td>
                    <td>{{ $client->last_name }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>{{ $client->email }}</td>
                    <td>{{ $client->address }}</td>
                    <td style="text-align:right; display:flex; justify-content:flex-end; gap:8px; align-items:center;">
                        <a class="btn btn-secondary" href="{{ route('admin.clients.edit', $client) }}">Uredi</a>

                        <a class="btn" href="{{ route('admin.clients.orders', $client) }}" style="background:#16a34a;">
                            Porudžbine
                        </a>

                        <form method="POST" action="{{ route('admin.clients.destroy', $client) }}" onsubmit="return confirm('Obrisati klijenta?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-secondary" type="submit" style="background:#dc2626; color:white;">Izbriši</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="muted">Nema klijenata.</td></tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top:12px;">
        <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">Nazad na početnu</a>
    </div>
</div>
@endsection
