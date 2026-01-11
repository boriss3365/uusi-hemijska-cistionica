<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware('auth')->group(function () {
    // USER PANEL (običan korisnik)
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Podešavanja profila (Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /**
     * USER rute (vidljive običnom korisniku) – po tvojoj logici:
     * - Nova porudžbina
     * - Aktivne porudžbine
     * - Usluge/Cjenovnik
     *
     * Napomena: za sada ih mapiramo na postojeće controllere,
     * a kasnije ćemo tačno implementirati UC1/UC2/UC3.
     */

    // Usluge/cjenovnik (read-only za user za sada)
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

    // Porudžbine (user vidi listu + kreiranje)
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

    // Ovdje ćemo dodati UC2 i UC3 rute (promjena statusa / preuzimanje) u sledećem koraku.
});

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // ADMIN PANEL
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // CRUD samo za admina
    Route::resource('clients', ClientController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('order-items', OrderItemController::class);
});

require __DIR__ . '/auth.php';
