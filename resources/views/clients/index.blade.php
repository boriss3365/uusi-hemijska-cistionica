@extends('layouts.app')

@section('content')
<div class="card">
    <div class="row" style="justify-content:space-between;">
        <h2 style="margin:0;">Klijenti</h2>
        <a class="btn" href="{{ route('clients.create') }}">Dodaj klijenta</a>
    </div>

    <table style="margin-top:12px;">
        <thead>
            <tr>
                <th>Ime</th>
                <th>Prezime</th>
                <th>Telefon</th>
                <th>Email</th>
                <th style="width:220px;">Akcije</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($clients as $client)
                <tr>
                    <td>{{ $client->first_name }}</td>
                    <td>{{ $client->last_name }}</td>
                    <td>{{ $client->phone }}</td>
                    <td>{{ $client->email }}</td>
                    <td class="row">
                        <a class="btn btn-secondary" href="{{ route('clients.edit', $client) }}">Uredi</a>

                        <form method="POST" action="{{ route('clients.destroy', $client) }}" onsubmit="return confirm('Obrisati klijenta?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Obriši</button>
                        </form>
                    </td>
                </tr>
            @endforeach

            @if($clients->count() === 0)
                <tr><td colspan="5">Nema klijenata.</td></tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
