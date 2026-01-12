@extends('layouts.app')

@section('content')
@php
    $isAdmin = request()->routeIs('admin.*');

    $formAction = $isAdmin
        ? route('admin.clients.update', $client)
        : route('clients.update', $client);

    $backUrl = $isAdmin ? route('admin.clients.index') : route('dashboard');
@endphp

<div class="card">
    <h2 style="margin-top:0;">Uredi klijenta</h2>

    <form method="POST" action="{{ $formAction }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Ime</label>
            <input name="first_name" value="{{ old('first_name', $client->first_name) }}" required>
        </div>

        <div class="form-group">
            <label>Prezime</label>
            <input name="last_name" value="{{ old('last_name', $client->last_name) }}" required>
        </div>

        <div class="form-group">
            <label>Telefon</label>
            <input name="phone" value="{{ old('phone', $client->phone) }}">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input name="email" value="{{ old('email', $client->email) }}">
        </div>

        <div class="form-group">
            <label>Adresa</label>
            <input name="address" value="{{ old('address', $client->address) }}">
        </div>

        <div class="row">
            <button class="btn" type="submit">Sačuvaj</button>
            <a class="btn btn-secondary" href="{{ $backUrl }}">Nazad</a>
        </div>
    </form>
</div>
@endsection
