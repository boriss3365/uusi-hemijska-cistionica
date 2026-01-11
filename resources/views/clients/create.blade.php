@extends('layouts.app')

@section('content')
<div class="card">
    <h2 style="margin-top:0;">Dodaj klijenta</h2>

    <form method="POST" action="{{ route('clients.store') }}">
        @csrf

        <div class="form-group">
            <label>Ime</label>
            <input name="first_name" value="{{ old('first_name') }}" required>
        </div>

        <div class="form-group">
            <label>Prezime</label>
            <input name="last_name" value="{{ old('last_name') }}" required>
        </div>

        <div class="form-group">
            <label>Telefon</label>
            <input name="phone" value="{{ old('phone') }}">
        </div>

        <div class="form-group">
            <label>Email</label>
            <input name="email" value="{{ old('email') }}">
        </div>

        <div class="form-group">
            <label>Adresa</label>
            <input name="address" value="{{ old('address') }}">
        </div>

        <div class="row">
            <button class="btn" type="submit">Sačuvaj</button>
            <a class="btn btn-secondary" href="{{ route('clients.index') }}">Nazad</a>
        </div>
    </form>
</div>
@endsection
