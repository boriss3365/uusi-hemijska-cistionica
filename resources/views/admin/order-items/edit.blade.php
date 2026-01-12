@extends('layouts.app')

@section('content')
<div class="card" style="max-width:850px;">
    <div class="row" style="justify-content:space-between; align-items:center; gap:12px;">
        <h2 style="margin:0;">Uredi stavku #{{ $item->id }}</h2>
        <a class="btn btn-secondary" href="{{ route('admin.order-items.index') }}">Nazad</a>
    </div>

    <div class="muted" style="margin-top:10px;">
        Porudžbina: #{{ $item->order_id }}
        —
        Klijent: {{ $item->order?->client?->first_name }} {{ $item->order?->client?->last_name }}
    </div>

    <form method="POST" action="{{ route('admin.order-items.update', $item) }}" style="margin-top:16px;">
        @csrf
        @method('PUT')

        <div style="margin-bottom:18px;">
            <label style="display:block; margin-bottom:6px;">Opis</label>
            <input name="description" value="{{ old('description', $item->description) }}" required>
            @error('description') <div class="muted" style="color:#dc2626;">{{ $message }}</div> @enderror
        </div>

        <div style="margin-bottom:18px;">
            <label style="display:block; margin-bottom:6px;">Usluga</label>
            <select name="service_id" required>
                <option value="">-- Izaberi uslugu --</option>
                @foreach($services as $s)
                    <option value="{{ $s->id }}" @selected((string)old('service_id', $item->service_id) === (string)$s->id)>
                        {{ $s->name }} ({{ number_format((float)$s->price, 2) }} EUR)
                    </option>
                @endforeach
            </select>
            @error('service_id') <div class="muted" style="color:#dc2626;">{{ $message }}</div> @enderror
        </div>

        <div style="margin-bottom:22px;">
            <label style="display:block; margin-bottom:6px;">Količina</label>
            <input type="number" min="1" max="100" name="quantity" value="{{ old('quantity', $item->quantity) }}" required>
            @error('quantity') <div class="muted" style="color:#dc2626;">{{ $message }}</div> @enderror
        </div>

        <div class="row" style="gap:10px;">
            <button class="btn" type="submit">Sačuvaj</button>
            <a class="btn btn-secondary" href="{{ route('admin.order-items.index') }}">Otkaži</a>
        </div>
    </form>
</div>
@endsection
