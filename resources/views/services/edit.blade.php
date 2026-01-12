@extends('layouts.app')

@section('content')
<div class="card" style="max-width:700px;">
    <h2 style="margin:0 0 22px 0;">Uredi uslugu</h2>

    <form method="POST" action="{{ route('admin.services.update', $service) }}">
        @csrf
        @method('PUT')

        <div style="margin-bottom:18px;">
            <label style="display:block; margin-bottom:6px;">Naziv usluge</label>
            <input name="name" value="{{ old('name', $service->name) }}" required>
        </div>

        <div style="margin-bottom:18px;">
            <label style="display:block; margin-bottom:6px;">Opis usluge</label>
            <input name="description" value="{{ old('description', $service->description) }}">
        </div>

        <div style="margin-bottom:22px;">
            <label style="display:block; margin-bottom:6px;">Cijena (EUR)</label>
            <input name="price" type="number" step="0.01" min="0" value="{{ old('price', $service->price) }}" required>
        </div>

        <div class="row" style="gap:10px;">
            <button class="btn" type="submit">Sačuvaj</button>
            <a class="btn btn-secondary" href="{{ route('admin.services.index') }}">Nazad</a>
        </div>
    </form>
</div>
@endsection
