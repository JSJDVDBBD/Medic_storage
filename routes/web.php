<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\AlertaController;
use App\Http\Controllers\CorteCajaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PuntoVentaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Medicamentos
    Route::resource('medicamentos', MedicamentoController::class);
    
    // Alertas
    Route::get('alertas', [AlertaController::class, 'index'])
        ->name('alertas.index');
    Route::patch('alertas/{alerta}/resolve', [AlertaController::class, 'resolve'])
        ->name('alertas.resolve');
    
    // Ventas
    Route::resource('ventas', VentaController::class)->except(['edit', 'update', 'destroy']);

    // routes/web.php
     Route::get('/punto-venta/{id}', [PuntoVentaController::class, 'show'])
     ->name('punto-venta.show');
    
    // Corte de Caja
    Route::resource('corte-caja', CorteCajaController::class);
    Route::post('corte-caja/{corte}/close', [CorteCajaController::class, 'close'])
        ->name('corte-caja.close');

    Route::resource('punto-venta', PuntoVentaController::class)
        ->parameters([
            'punto-venta'=>'puntoVenta'
        ])
        ->except([]);

    Route::resource('roles',RoleController::class)
        ->except(['show']);

    Route::resource('ventas', SaleController::class)
        ->except(['index', 'update', 'destroy','show']);

    Route::resource('users',UserController::class)
        ->except(['show','destroy']);
});

require __DIR__.'/auth.php';