@extends('layouts.app')

@section('title', 'Nuevo Corte de Caja')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-6 flex items-center">
            <i class="fas fa-calculator mr-2"></i> Nuevo Corte de Caja
        </h1>

        @if(isset($ventasEfectivo) && isset($ventasTarjeta) && isset($ventasTransferencia))
        <form action="{{ route('corte-caja.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Efectivo Inicial -->
                <div class="mb-4">
                    <label for="efectivo_inicial" class="block text-gray-700 font-medium mb-2">
                        Efectivo Inicial
                    </label>
                    <input type="number" step="0.01" name="efectivo_inicial" id="efectivo_inicial"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>

                <!-- Efectivo Final -->
                <div class="mb-4">
                    <label for="efectivo_final" class="block text-gray-700 font-medium mb-2">
                        Efectivo Final
                    </label>
                    <input type="number" step="0.01" name="efectivo_final" id="efectivo_final"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                        required>
                </div>
            </div>

            <!-- Resumen de Ventas -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h3 class="font-semibold text-lg mb-3">Resumen de Ventas del Día</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="p-3 bg-white rounded shadow">
                        <p class="text-gray-600">Ventas en Efectivo</p>
                        <p class="text-xl font-bold">${{ number_format($ventasEfectivo, 2) }}</p>
                    </div>
                    <div class="p-3 bg-white rounded shadow">
                        <p class="text-gray-600">Ventas con Tarjeta</p>
                        <p class="text-xl font-bold">${{ number_format($ventasTarjeta, 2) }}</p>
                    </div>
                    <div class="p-3 bg-white rounded shadow">
                        <p class="text-gray-600">Ventas por Transferencia</p>
                        <p class="text-xl font-bold">${{ number_format($ventasTransferencia, 2) }}</p>
                    </div>
                </div>
                
                <div class="mt-4 p-3 bg-white rounded shadow">
                    <p class="text-gray-600">Total Ventas del Día</p>
                    <p class="text-xl font-bold">${{ number_format($ventasEfectivo + $ventasTarjeta + $ventasTransferencia, 2) }}</p>
                </div>
            </div>

            <!-- Observaciones -->
            <div class="mb-6">
                <label for="observaciones" class="block text-gray-700 font-medium mb-2">
                    Observaciones
                </label>
                <textarea name="observaciones" id="observaciones" rows="3"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
            </div>

            <!-- Botones -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('corte-caja.index') }}"
                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition">
                    Cancelar
                </a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Guardar Corte
                </button>
            </div>
        </form>
        @else
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4" role="alert">
            <p>No se pudieron cargar los datos de ventas. Por favor intente nuevamente.</p>
        </div>
        @endif
    </div>
</div>
@endsection