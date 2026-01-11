@extends('layouts.app')

@section('content')
<div class="card">
    <h2 style="margin:0 0 10px 0;">Usluge / Cjenovnik</h2>
    <div class="muted">Pregled dostupnih usluga i cijena.</div>

    <table>
        <thead>
            <tr>
                <th>Naziv usluge</th>
                <th>Opis usluge</th>
                <th style="width:140px;">Cijena (EUR)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $service)
                <tr>
                    <td><strong>{{ $service->name }}</strong></td>
                    <td>{{ $service->description }}</td>
                    <td>{{ number_format((float)$service->price, 2) }}</td>
                </tr>
            @endforeach

            @if($services->count() === 0)
                <tr><td colspan="3">Nema unijetih usluga.</td></tr>
            @endif
        </tbody>
    </table>
</div>
@endsection
