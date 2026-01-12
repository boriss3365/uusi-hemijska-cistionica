<?php

use App\Http\Controllers\AdminClientController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('register');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function (Request $request) {
        $userId = $request->user()->id;

        $activeOrders = Order::with('client')
            ->where('user_id', $userId)
            ->where('status', '!=', 'preuzeto')
            ->orderByDesc('id')
            ->get();

        return view('dashboard', compact('activeOrders'));
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');

    Route::post('/clients', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/clients/create', [ClientController::class, 'create'])->name('clients.create');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');

});

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {

    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    Route::get('/orders', [OrderController::class, 'adminIndex'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'createAdmin'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'storeAdmin'])->name('orders.store');
    Route::resource('orders', OrderController::class)->except(['index', 'create', 'store']);

    Route::get('/clients/{client}/orders', [AdminClientController::class, 'orders'])->name('clients.orders');
    Route::resource('clients', AdminClientController::class);
    Route::resource('services', \App\Http\Controllers\AdminServiceController::class);
    Route::resource('order-items', OrderItemController::class);
});

require __DIR__.'/auth.php';
