@extends('layouts.app')

@section('content')
@php
    $isAdmin = request()->routeIs('admin.*');

    $formAction = $isAdmin ? route('admin.clients.store') : route('clients.store');
    $backUrl = $isAdmin ? route('admin.clients.index') : route('orders.create');
@endphp

<div class="card" style="max-width:700px;">
    <h2 style="margin:0 0 22px 0;">Dodaj klijenta</h2>

    <form method="POST" action="{{ $formAction }}">
        @csrf

        <div style="margin-bottom:18px;">
            <label style="display:block; margin-bottom:6px;">Ime</label>
            <input name="first_name" value="{{ old('first_name') }}" required>
        </div>

        <div style="margin-bottom:18px;">
            <label style="display:block; margin-bottom:6px;">Prezime</label>
            <input name="last_name" value="{{ old('last_name') }}" required>
        </div>

        <div style="margin-bottom:18px;">
            <label style="display:block; margin-bottom:6px;">Telefon</label>
            <input name="phone" value="{{ old('phone') }}">
        </div>

        <div style="margin-bottom:18px;">
            <label style="display:block; margin-bottom:6px;">Email</label>
            <input name="email" value="{{ old('email') }}">
        </div>

        <div style="margin-bottom:22px;">
            <label style="display:block; margin-bottom:6px;">Adresa</label>
            <input name="address" value="{{ old('address') }}">
        </div>

        <div class="row" style="gap:10px;">
            <button class="btn" type="submit">Sačuvaj</button>
            <a class="btn btn-secondary" href="{{ $backUrl }}">Nazad</a>
        </div>
    </form>
</div>
@endsection
