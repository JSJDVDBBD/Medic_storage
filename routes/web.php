<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\AlertaController;
use App\Http\Controllers\CorteCajaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

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
    
    // Corte de Caja
    Route::resource('corte-caja', CorteCajaController::class);
    Route::post('corte-caja/{corte}/close', [CorteCajaController::class, 'close'])
        ->name('corte-caja.close');
});

require __DIR__.'/auth.php';