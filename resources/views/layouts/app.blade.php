<!doctype html>
<html lang="sr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Hemijska cistionica') }}</title>

    <style>
        body { font-family: Arial, sans-serif; margin:0; background:#f3f4f6; }
        .topbar { background:#111827; color:#fff; padding:12px 18px; display:flex; justify-content:space-between; align-items:center; }
        .brand { font-weight:700; }
        .topbar-right { display:flex; align-items:center; gap:10px; font-size:14px; }
        .container { display:flex; min-height: calc(100vh - 48px); }
        .sidebar { width: 240px; background:#1f2937; color:#fff; padding:14px; }
        .sidebar a { display:block; color:#fff; text-decoration:none; padding:10px 12px; border-radius:8px; margin-bottom:8px; font-size:14px; }
        .sidebar a:hover { background:#374151; }
        .content { flex:1; padding:18px; }
        .card { background:#fff; border-radius:12px; padding:16px; box-shadow:0 1px 3px rgba(0,0,0,.08); border:1px solid #e5e7eb; }
        .row { display:flex; gap:10px; align-items:center; flex-wrap:wrap; }
        .btn { display:inline-block; padding:10px 14px; background:#111827; color:#fff; border-radius:10px; text-decoration:none; border:none; cursor:pointer; font-size:14px; }
        .btn-secondary { background:#6b7280; }
        table { width:100%; border-collapse: collapse; margin-top:10px; }
        th, td { padding:10px; border-bottom:1px solid #e5e7eb; text-align:left; font-size:14px; }
        .muted { color:#6b7280; font-size:14px; }
        .logout-btn { background:#374151; border:none; color:#fff; padding:8px 12px; border-radius:10px; cursor:pointer; }
        .logout-btn:hover { background:#4b5563; }
    </style>
</head>
<body>
    <div class="topbar">
        <div class="brand">Hemijska cistionica</div>

        @auth
            <div class="topbar-right">
                <div>Zdravo, {{ auth()->user()->name }}</div>
                <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                    @csrf
                    <button type="submit" class="logout-btn">Logout</button>
                </form>
            </div>
        @endauth
    </div>

    <div class="container">
        <div class="sidebar">
            @auth
                <a href="{{ route('dashboard') }}">Početna</a>

                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}">Admin panel</a>
                    <a href="{{ url('/admin/orders') }}">Porudžbine (CRUD)</a>
                    <a href="{{ url('/admin/clients') }}">Klijenti (CRUD)</a>
                    <a href="{{ url('/admin/services') }}">Usluge (CRUD)</a>
                    <a href="{{ url('/admin/order-items') }}">Stavke porudžbine (CRUD)</a>
                @else
                    <a href="{{ route('orders.create') }}">Nova porudžbina</a>
                    <a href="{{ route('orders.index') }}">Aktivne porudžbine</a>
                    <a href="{{ route('services.index') }}">Usluge / Cjenovnik</a>
                    <a href="{{ route('profile.edit') }}">Podešavanja</a>
                @endif
            @endauth
        </div>

        <div class="content">
                @if (session('success'))
                    <div class="card" style="border-left:6px solid #16a34a; margin-bottom:12px;">
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="card" style="border-left:6px solid #b91c1c; margin-bottom:12px;">
                        <ul style="margin:0; padding-left:18px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            @yield('content')
        </div>

    </div>
</body>
</html>
