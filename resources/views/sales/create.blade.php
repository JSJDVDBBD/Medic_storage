@extends('layouts.app')

@section('title', 'Crear Rol')

@section('styles')
    <!--Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endsection
@section('content')
    <div class="container mx-auto px-4 py-6">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($errors->has('stock'))
            <div class="alert alert-warning">{{ $errors->first('stock') }}</div>
        @endif
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold mb-6 flex items-center">
                <i class="fas fa-cash-register mr-3"></i> Registrar nueva venta
            </h2>
            <form action="{{ route('ventas.store') }}" method="POST">
                @csrf
                <div class="gap-6">
                    <div class="mb-4">
                        <label for="codigo" class="block text-gray-700 font-medium mb-2">Código de venta</label>
                        <input type="text" name="codigo" id="codigo"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    <div class="mb-4">

                        <div id="productos-container">
                            <h4 class="font-semibold mt-6 mb-2">Medicamentos</h4>
                            <div class="producto-item border p-3 mb-3 rounded bg-gray-50">
                                <div class="grid grid-cols-5 gap-4">
                                    <div>
                                        <label class="block text-gray-700 font-medium mb-2">Medicamento</label>
                                        <select name="productos[0][medicamento_id]"
                                            class="medicamento-select w-full border rounded px-4 py-2" required></select>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 font-medium mb-2">Cantidad</label>
                                        <input type="number" name="productos[0][cantidad]"
                                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            min="1" required>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 font-medium mb-2">Precio Unitario</label>
                                        <input type="number" step="0.01" name="productos[0][precio_unitario]"
                                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            required>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 font-medium mb-2">Subtotal</label>
                                        <input type="number" step="0.01" name="productos[0][subtotal]"
                                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                            required>
                                    </div>
                                    <div>
                                        <label class="block text-gray-700 font-medium mb-2">Descuento</label>
                                        <input type="number" step="0.01" name="productos[0][descuento]"
                                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                </div>
                            </div>
                        </div>


                        <button type="button" id="add-producto" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded">+
                            Agregar
                            producto</button>

                        <div class="grid grid-cols-2 gap-4 mt-6">
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Subtotal</label>
                                <input type="number" step="0.01" name="subtotal"
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Impuesto</label>
                                <input type="number" step="0.01" name="impuesto"
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Descuento total</label>
                                <input type="number" step="0.01" name="descuento"
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-2">Total</label>
                                <input type="number" step="0.01" name="total"
                                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                    required>
                            </div>
                        </div>

                        <div class="mt-4">
                            <label class="block text-gray-700 font-medium mb-2">Método de pago</label>
                            <select name="metodo_pago"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                required>
                                <option value="" disabled selected>Selecciona un método</option>
                                <option value="EFECTIVO">Efectivo</option>
                                <option value="TRANSFERENCIA">Transferencia</option>
                                <option value="TARJETA">Tarjeta</option>
                            </select>
                        </div>

                        <div class="mt-4">
                            <label class="block text-gray-700 font-medium mb-2">Observaciones</label>
                            <textarea name="observaciones"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Registrar
                                venta</button>
                        </div>

                    </div>

                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        function inicializarSelect2(selector) {
            $(selector).select2({
                placeholder: 'Buscar medicamento...',
                ajax: {
                    url: '/api/search/medicamentos',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term
                        };
                    },
                    processResults: function(data) {
                        return {
                            results: data.map(med => ({
                                id: med.id,
                                text: med.nombre,
                                precio: med.precio_venta
                            }))
                        };
                    },
                    cache: true
                }
            }).on('select2:select', function(e) {
                const data = e.params.data;
                console.log(data)
                const container = $(this).closest('.producto-item');

                // Setear precio
                const precioInput = container.find('input[name$="[precio_unitario]"]');
                precioInput.val(data.precio);

                // Calcular subtotal si ya hay cantidad
                const cantidadInput = container.find('input[name$="[cantidad]"]');
                const subtotalInput = container.find('input[name$="[subtotal]"]');

                const cantidad = parseFloat(cantidadInput.val());
                if (!isNaN(cantidad)) {
                    subtotalInput.val((cantidad * data.precio).toFixed(2));
                }
            });
        }

        $(document).ready(function() {
            inicializarSelect2('.medicamento-select');

            let productoIndex = 1;

            // Calcular subtotal automáticamente cuando se cambia cantidad o precio
            $(document).on('input', 'input[name$="[cantidad]"], input[name$="[precio_unitario]"]', function() {
                const container = $(this).closest('.producto-item');
                const cantidad = parseFloat(container.find('input[name$="[cantidad]"]').val()) || 0;
                const precio = parseFloat(container.find('input[name$="[precio_unitario]"]').val()) || 0;
                const subtotalInput = container.find('input[name$="[subtotal]"]');
                subtotalInput.val((cantidad * precio).toFixed(2));
            });

            $('#add-producto').on('click', function() {
                const html = `
            <div class="producto-item border p-3 mb-3 rounded bg-gray-50">
                <div class="grid grid-cols-5 gap-4">
                    <div>
                        <label>Medicamento</label>
                        <select name="productos[${productoIndex}][medicamento_id]" class="medicamento-select w-full border rounded px-2 py-1" required></select>
                    </div>
                    <div>
                        <label>Cantidad</label>
                        <input type="number" name="productos[${productoIndex}][cantidad]" class="w-full border rounded px-2 py-1" min="1" required>
                    </div>
                    <div>
                        <label>Precio Unitario</label>
                        <input type="number" step="0.01" name="productos[${productoIndex}][precio_unitario]" class="w-full border rounded px-2 py-1" required>
                    </div>
                    <div>
                        <label>Subtotal</label>
                        <input type="number" step="0.01" name="productos[${productoIndex}][subtotal]" class="w-full border rounded px-2 py-1" required>
                    </div>
                    <div>
                        <label>Descuento</label>
                        <input type="number" step="0.01" name="productos[${productoIndex}][descuento]" class="w-full border rounded px-2 py-1">
                    </div>
                </div>
            </div>`;

                $('#productos-container').append(html);
                inicializarSelect2(`select[name="productos[${productoIndex}][medicamento_id]"]`);
                productoIndex++;
            });
        });
    </script>

@endsection
