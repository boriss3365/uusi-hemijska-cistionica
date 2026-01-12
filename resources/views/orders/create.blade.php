@extends('layouts.app')

@section('content')
<div class="card">
    <h2 style="margin:0 0 14px 0;">Nova porudžbina</h2>

    @php
        $isAdminCreate = request()->routeIs('admin.orders.create');
        $formAction = $isAdminCreate ? route('admin.orders.store') : route('orders.store');
    @endphp

    <form method="POST" action="{{ $formAction }}" id="orderForm">
        @csrf



        <div class="card" style="background:#f9fafb; border:1px solid #e5e7eb; margin-bottom:14px;">
            <h3 style="margin:0 0 10px 0;">Podaci o klijentu</h3>

            <div class="row" style="align-items:flex-end; gap:14px;">
                <div style="flex:3; min-width:300px;">
                    <label>Klijent</label>

                    @php
                        $selectedClientId = old('client_id', session('new_client_id'));
                    @endphp

                    <select name="client_id" required>
                        <option value="">-- Izaberi klijenta --</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" @selected((string)$selectedClientId === (string)$client->id)>
                                {{ $client->first_name }} {{ $client->last_name }} ({{ $client->phone }})
                            </option>
                        @endforeach
                    </select>
                </div>

                @if(!$isAdminCreate)
                    <div style="min-width:220px;">
                        <a class="btn" href="{{ route('clients.create') }}" style="background:#2563eb;">Dodaj novog klijenta</a>
                    </div>
                @endif
            </div>
        </div>

        <div class="card" style="background:#f9fafb; border:1px solid #e5e7eb;">
            <h3 style="margin:0 0 10px 0;">Stavke garderobe</h3>

            <div class="row" style="align-items:flex-end; gap:14px; margin-bottom:10px;">
                <div style="flex:3; min-width:280px;">
                    <label>Opis garderobe</label>
                    <input id="itemDescription" type="text" placeholder="npr. Košulja">
                </div>

                <div style="flex:3; min-width:280px;">
                    <label>Usluga</label>
                    <select id="itemService">
                        <option value="">-- Izaberi uslugu --</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}" data-price="{{ $service->price }}">
                                {{ $service->name }} ({{ number_format((float)$service->price, 2) }} EUR)
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="flex:1; min-width:140px;">
                    <label>Količina</label>
                    <input id="itemQty" type="number" min="1" value="1">
                </div>

                <div style="min-width:150px; display:flex; justify-content:flex-end;">
                    <button type="button" class="btn" id="addItemBtn" style="background:#16a34a;">
                        Dodaj stavku
                    </button>
                </div>
            </div>

            <table id="itemsTable">
                <thead>
                    <tr>
                        <th>Opis</th>
                        <th>Usluga</th>
                        <th style="width:120px;">Količina</th>
                        <th style="width:160px;">Cijena</th>
                        <th style="width:90px;"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr id="emptyRow">
                        <td colspan="5" class="muted">Nema dodatih stavki.</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div id="itemsInputs"></div>

        <div style="height:14px;"></div>

        <div class="row" style="justify-content:space-between; gap:14px;">
            <div class="row" style="gap:12px; align-items:center;">
                <div class="muted" style="min-width:110px;">Ukupna cijena:</div>
                <input type="text" id="totalField" value="0.00 EUR" readonly style="max-width:240px;">
            </div>

            <div class="row" style="gap:10px;">
                <button class="btn" type="submit" id="saveBtn" disabled>Sačuvaj porudžbinu</button>
                <a class="btn btn-secondary" href="{{ $isAdminCreate ? route('admin.orders.index') : route('dashboard') }}">Otkaži</a>
            </div>
        </div>
    </form>
</div>

<script>
(function () {
    const tbody = document.querySelector('#itemsTable tbody');
    const emptyRow = document.getElementById('emptyRow');
    const inputsBox = document.getElementById('itemsInputs');

    const addBtn = document.getElementById('addItemBtn');
    const saveBtn = document.getElementById('saveBtn');

    const descEl = document.getElementById('itemDescription');
    const serviceEl = document.getElementById('itemService');
    const qtyEl = document.getElementById('itemQty');
    const totalField = document.getElementById('totalField');

    let items = [];

    function formatMoney(n) {
        return (Math.round(n * 100) / 100).toFixed(2) + ' EUR';
    }

    function recalcTotal() {
        const total = items.reduce((sum, it) => sum + it.line_total, 0);
        totalField.value = formatMoney(total);
        saveBtn.disabled = items.length === 0;
    }

    function render() {
        tbody.innerHTML = '';
        inputsBox.innerHTML = '';

        if (items.length === 0) {
            tbody.appendChild(emptyRow);
            recalcTotal();
            return;
        }

        items.forEach((it, idx) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td>${it.description}</td>
                <td>${it.service_name}</td>
                <td>${it.quantity}</td>
                <td>${formatMoney(it.line_total)}</td>
                <td><button type="button" class="btn btn-secondary" data-remove="${idx}">X</button></td>
            `;
            tbody.appendChild(tr);

            inputsBox.insertAdjacentHTML('beforeend', `
                <input type="hidden" name="items[${idx}][description]" value="${it.description.replaceAll('"','&quot;')}">
                <input type="hidden" name="items[${idx}][service_id]" value="${it.service_id}">
                <input type="hidden" name="items[${idx}][quantity]" value="${it.quantity}">
            `);
        });

        recalcTotal();
    }

    addBtn.addEventListener('click', function () {
        const description = (descEl.value || '').trim();
        const serviceId = serviceEl.value;
        const qty = parseInt(qtyEl.value || '0', 10);

        const opt = serviceEl.options[serviceEl.selectedIndex];
        const serviceName = opt ? opt.text : '';
        const price = opt ? parseFloat(opt.getAttribute('data-price') || '0') : 0;

        if (!description) { alert('Unesi opis garderobe.'); return; }
        if (!serviceId) { alert('Izaberi uslugu.'); return; }
        if (!qty || qty < 1) { alert('Količina mora biti najmanje 1.'); return; }

        items.push({
            description,
            service_id: serviceId,
            service_name: serviceName,
            quantity: qty,
            line_total: qty * price
        });

        descEl.value = '';
        serviceEl.value = '';
        qtyEl.value = 1;

        render();
    });

    document.addEventListener('click', function (e) {
        const btn = e.target.closest('[data-remove]');
        if (!btn) return;

        const idx = parseInt(btn.getAttribute('data-remove'), 10);
        items.splice(idx, 1);
        render();
    });

    render();
})();
</script>
@endsection
