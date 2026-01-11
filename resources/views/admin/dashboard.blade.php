@extends('layouts.app')

@section('content')
<div class="card">
    <h2 style="margin-top:0;">Admin panel</h2>
    <p>CRUD (izmjena svih podataka) je dostupan samo adminu.</p>

    <div class="row">
        <a class="btn" href="{{ url('/admin/orders') }}">Porudžbine</a>
        <a class="btn" href="{{ url('/admin/clients') }}">Klijenti</a>
        <a class="btn" href="{{ url('/admin/services') }}">Usluge</a>
        <a class="btn" href="{{ url('/admin/order-items') }}">Stavke porudžbine</a>
    </div>
</div>
@endsection
