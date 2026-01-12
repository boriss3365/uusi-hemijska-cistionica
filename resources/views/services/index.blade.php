@extends('layouts.app')

@section('content')
@php
    $isAdmin = request()->routeIs('admin.services.*');
@endphp

<div class="card">
    <div class="row" style="justify-content:space-between; align-items:center; gap:12px;">
        <div>
            <h2 style="margin:0 0 6px 0;">Usluge / Cjenovnik</h2>
            <div class="muted">Pregled dostupnih usluga i cijena.</div>
        </div>

        @if($isAdmin)
            <a class="btn" href="{{ route('admin.services.create') }}" style="background:#2563eb;">
                Dodaj novu uslugu
            </a>
        @endif
    </div>

    @if(session('success'))
        <div class="card" style="background:#ecfdf5; border:1px solid #a7f3d0; margin-top:12px;">
            {{ session('success') }}
        </div>
    @endif

    <table style="margin-top:12px;">
        <thead>
            <tr>
                <th>Naziv usluge</th>
                <th>Opis usluge</th>
                <th style="width:140px;">Cijena (EUR)</th>
                @if($isAdmin)
                    <th style="width:220px;"></th>
                @endif
            </tr>
        </thead>
        <tbody>
            @forelse($services as $service)
                <tr>
                    <td><strong>{{ $service->name }}</strong></td>
                    <td>{{ $service->description }}</td>
                    <td>{{ number_format((float)$service->price, 2) }}</td>

                    @if($isAdmin)
                        <td style="text-align:right;">
                            <div class="row" style="justify-content:flex-end; gap:8px;">
                                <a class="btn btn-secondary" href="{{ route('admin.services.edit', $service) }}">
                                    Uredi
                                </a>

                                <form method="POST"
                                      action="{{ route('admin.services.destroy', $service) }}"
                                      onsubmit="return confirm('Obrisati ovu uslugu?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-secondary" type="submit" style="background:#dc2626; color:white;">
                                        Izbriši
                                    </button>
                                </form>
                            </div>
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="{{ $isAdmin ? 4 : 3 }}">Nema unijetih usluga.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($isAdmin)
        <div style="margin-top:12px;">
            <a class="btn btn-secondary" href="{{ route('admin.dashboard') }}">Nazad na početnu</a>
        </div>
    @endif
</div>
@endsection
