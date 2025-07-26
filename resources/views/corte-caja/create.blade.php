@extends('layouts.app')

@section('title', 'Nuevo Corte de Caja')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-full">
                    <i class="fas fa-calculator text-blue-600 text-2xl"></i>
                </div>
                <h1 class="ml-4 text-2xl font-bold text-gray-800">Nuevo Corte de Caja</h1>
            </div>
            <div class="text-sm text-gray-500">
                {{ now()->format('d/m/Y') }}
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2"></div>
            
            <div class="p-6 sm:p-8">
                <form action="{{ route('corte-caja.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <div>
                                <label for="fecha" class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                                <input type="date" name="fecha" id="fecha" value="{{ today()->toDateString() }}"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150">
                            </div>

                            <div>
                                <label for="efectivo_inicial" class="block text-sm font-medium text-gray-700 mb-1">Efectivo Inicial</label>
                                <div class="relative rounded-md shadow-sm">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <span class="text-gray-500 sm:text-sm">$</span>
                                    </div>
                                    <input type="number" step="0.01" name="efectivo_inicial" id="efectivo_inicial"
                                        class="w-full pl-7 pr-12 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="0.00" required>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Efectivo Final Calculado</label>
                                <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                    <p class="text-xl font-semibold text-green-800" id="efectivo_final_calculado">
                                        $<span>0.00</span>
                                    </p>
                                    <input type="hidden" name="efectivo_final" id="efectivo_final" value="0">
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ventas en Efectivo</label>
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                    <p class="text-xl font-semibold text-blue-800">${{ number_format($totalEfectivo, 2) }}</p>
                                    <input type="hidden" name="ventas_efectivo" value="{{ $totalEfectivo }}">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ventas por Transferencia</label>
                                <div class="bg-green-50 border border-green-200 rounded-lg p-3">
                                    <p class="text-xl font-semibold text-green-800">${{ number_format($totalTransferencia, 2) }}</p>
                                    <input type="hidden" name="ventas_transferencia" value="{{ $totalTransferencia }}">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ventas con Tarjeta</label>
                                <div class="bg-purple-50 border border-purple-200 rounded-lg p-3">
                                    <p class="text-xl font-semibold text-purple-800">${{ number_format($totalTarjeta, 2) }}</p>
                                    <input type="hidden" name="ventas_tarjeta" value="{{ $totalTarjeta }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-1">Observaciones</label>
                        <textarea name="observaciones" id="observaciones" rows="3" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-150"
                            placeholder="Notas adicionales sobre el corte..."></textarea>
                    </div>

                    <input type="hidden" name="total_ventas" value="{{ $totalVentas }}">

                    <div class="mt-8 flex justify-end">
                        <button type="submit" 
                            class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150">
                            <i class="fas fa-save mr-2"></i> Guardar Corte
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const efectivoInicial = document.getElementById('efectivo_inicial');
        const ventasEfectivo = {{ $totalEfectivo }};
        const efectivoFinalSpan = document.querySelector('#efectivo_final_calculado span');
        const efectivoFinalInput = document.getElementById('efectivo_final');

        function calcularEfectivoFinal() {
            const inicial = parseFloat(efectivoInicial.value) || 0;
            const total = inicial + ventasEfectivo;
            
            efectivoFinalSpan.textContent = total.toFixed(2);
            efectivoFinalInput.value = total;
        }

        calcularEfectivoFinal();
        efectivoInicial.addEventListener('input', calcularEfectivoFinal);
    });
</script>
@endpush
@endsection