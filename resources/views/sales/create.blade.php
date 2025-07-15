@extends('layouts.app')

@section('title', 'Crear Rol')

@section('content')
    <div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if ($errors->has('stock'))
            <div class="alert alert-warning">{{ $errors->first('stock') }}</div>
        @endif

        <h2 class="text-2xl font-semibold mb-4">Registrar nueva venta</h2>

        <form action="{{ route('ventas.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label for="codigo" class="block font-medium">Código de venta</label>
                <input type="text" name="codigo" id="codigo" class="w-full border rounded px-3 py-2" required>
            </div>


            <div id="productos-container">
                <h4 class="font-semibold mt-6 mb-2">Medicamentos</h4>
                <div class="producto-item border p-3 mb-3 rounded bg-gray-50">
                    <div class="grid grid-cols-5 gap-4">
                        <div>
                            <label>Medicamento</label>
                            <select name="productos[0][medicamento_id]" class="w-full border rounded px-2 py-1" required>
                                <option value="">Seleccione...</option>
                                @foreach ($medicamentos as $medicamento)
                                    <option value="{{ $medicamento->id }}">{{ $medicamento->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label>Cantidad</label>
                            <input type="number" name="productos[0][cantidad]" class="w-full border rounded px-2 py-1"
                                min="1" required>
                        </div>
                        <div>
                            <label>Precio Unitario</label>
                            <input type="number" step="0.01" name="productos[0][precio_unitario]"
                                class="w-full border rounded px-2 py-1" required>
                        </div>
                        <div>
                            <label>Subtotal</label>
                            <input type="number" step="0.01" name="productos[0][subtotal]"
                                class="w-full border rounded px-2 py-1" required>
                        </div>
                        <div>
                            <label>Descuento</label>
                            <input type="number" step="0.01" name="productos[0][descuento]"
                                class="w-full border rounded px-2 py-1">
                        </div>
                    </div>
                </div>
            </div>

            <button type="button" id="add-producto" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded">+ Agregar
                producto</button>

            <div class="grid grid-cols-2 gap-4 mt-6">
                <div>
                    <label>Subtotal</label>
                    <input type="number" step="0.01" name="subtotal" class="w-full border rounded px-2 py-1" required>
                </div>
                <div>
                    <label>Impuesto</label>
                    <input type="number" step="0.01" name="impuesto" class="w-full border rounded px-2 py-1" required>
                </div>
                <div>
                    <label>Descuento total</label>
                    <input type="number" step="0.01" name="descuento" class="w-full border rounded px-2 py-1">
                </div>
                <div>
                    <label>Total</label>
                    <input type="number" step="0.01" name="total" class="w-full border rounded px-2 py-1" required>
                </div>
            </div>

            <div class="mt-4">
                <label>Método de pago</label>
                <input type="text" name="metodo_pago" class="w-full border rounded px-2 py-1" required>
            </div>

            <div class="mt-4">
                <label>Observaciones</label>
                <textarea name="observaciones" class="w-full border rounded px-2 py-1"></textarea>
            </div>

            <div class="mt-6">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Registrar venta</button>
            </div>
        </form>
    </div>

    <script>
        let productoIndex = 1;

        document.getElementById('add-producto').addEventListener('click', function() {
            const container = document.getElementById('productos-container');

            const html = `
        <div class="producto-item border p-3 mb-3 rounded bg-gray-50">
            <div class="grid grid-cols-5 gap-4">
                <div>
                    <select name="productos[${productoIndex}][medicamento_id]" class="w-full border rounded px-2 py-1" required>
                        <option value="">Seleccione...</option>
                        @foreach ($medicamentos as $medicamento)
                            <option value="{{ $medicamento->id }}">{{ $medicamento->nombre }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <input type="number" name="productos[${productoIndex}][cantidad]" class="w-full border rounded px-2 py-1" min="1" required>
                </div>
                <div>
                    <input type="number" step="0.01" name="productos[${productoIndex}][precio_unitario]" class="w-full border rounded px-2 py-1" required>
                </div>
                <div>
                    <input type="number" step="0.01" name="productos[${productoIndex}][subtotal]" class="w-full border rounded px-2 py-1" required>
                </div>
                <div>
                    <input type="number" step="0.01" name="productos[${productoIndex}][descuento]" class="w-full border rounded px-2 py-1">
                </div>
            </div>
        </div>`;

            container.insertAdjacentHTML('beforeend', html);
            productoIndex++;
        });
    </script>
@endsection
