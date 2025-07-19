@extends('layouts.app')

@section('title', 'Crear Corte de Caja')

@section('content')


    <div class="container mx-auto px-4 py-6">
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-6 flex items-center">
                <i class="fas fa-calculator mr-3"></i> Corte de caja
            </h2>



            <form action="{{ route('corte-caja.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="gap-6">

                    <div class="mb-4">

                        <label for="fecha" 
                        class="block text-gray-700 font-medium mb-2">Fecha</label>
                        <input type="date" name="fecha" id="fecha" value="{{ today()->toDateString() }}"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="efectivo_inicial" 
                        class="block text-gray-700 font-medium mb-2">Efectivo Inicial</label>
                        <input type="number" step="0.01" name="efectivo_inicial" id="efectivo_inicial"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Ventas Efectivo</label>
                        <input type="text" readonly value="${{ number_format($totalEfectivo, 2) }}"
                            class="w-full bg-gray-100 border rounded p-2">
                        <input type="hidden" name="ventas_efectivo" value="{{ $totalEfectivo }}">
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-2">Ventas Transferencia</label>
                        <input type="text" readonly value="${{ number_format($totalTransferencia, 2) }}"
                            class="w-full bg-gray-100 border rounded p-2">
                        <input type="hidden" name="ventas_transferencia" value="{{ $totalTransferencia }}">
                    </div>

                    <div class="mb-4">
                        <label for="ventas_tarjeta" class="block text-gray-700 font-medium mb-2">Ventas Tarjeta</label>
                        <input type="number" step="0.01" name="ventas_tarjeta" id="ventas_tarjeta"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" value="0.00" required>
                    </div>

                    <div class="mb-4">
                        <label for="efectivo_final" class="block text-gray-700 font-medium mb-2">Efectivo Final</label>
                        <input type="number" step="0.01" name="efectivo_final" id="efectivo_final"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="observaciones" class="block text-gray-700 font-medium mb-2">Observaciones</label>
                        <textarea name="observaciones" id="observaciones" rows="3" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500    "></textarea>
                    </div>

                    {{-- Hidden Totales --}}
                    <input type="hidden" name="total_ventas" value="{{ $totalVentas }}">

                    {{-- Calcula el total esperado en el controller si deseas mayor seguridad --}}
                    <input type="hidden" name="total_esperado" value="{{ $totalEfectivo + $totalTransferencia }}">

                    {{-- Puedes calcular la diferencia en el backend para evitar manipulación del lado cliente --}}
                    <input type="hidden" name="diferencia" value="0">

                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar
                        Corte</button>

                </div>
            </form>
        </div>
    </div>
@endsection
