@extends('layouts.app')

@section('title', 'Registrar nueva venta')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    body {
        background-color: #f1f8f6;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .bg-white {
        background-color: #ffffff;
    }

    .shadow-md {
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    .text-xl {
        color: #2c7a7b;
    }

    .bg-blue-500, .bg-blue-600 {
        background-color: #2b6cb0 !important;
    }

    .bg-green-600 {
        background-color: #38a169 !important;
    }

    .hover\:bg-blue-600:hover {
        background-color: #2c5282 !important;
    }

    .hover\:bg-green-700:hover {
        background-color: #2f855a !important;
    }

    .rounded-lg {
        border-radius: 8px;
    }

    .rounded {
        border-radius: 4px;
    }

    .border {
        border: 1px solid #e2e8f0;
    }

    .producto-item {
        border: 1px solid #c6f6d5;
        background-color: #f0fff4;
        position: relative;
    }

    .producto-item label {
        color: #276749;
        font-weight: 600;
    }

    .producto-item .descuento {
        background-color: #fefcbf;
    }

    .producto-item .aplicar_descuento {
        accent-color: #38a169;
    }

    .bg-gray-50 {
        background-color: #f7fafc;
    }

    .text-gray-700 {
        color: #4a5568;
    }

    .focus\:ring-blue-500:focus {
        box-shadow: 0 0 0 3px rgba(66,153,225,.5);
    }

    .bg-white form {
        background: linear-gradient(to right, #ffffff, #f0fff4);
    }

    .btn-eliminar {
        position: absolute;
        top: 5px;
        right: 5px;
        background-color: #e53e3e;
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 12px;
    }

    .btn-eliminar:hover {
        background-color: #c53030;
    }
</style>
@endsection

@section('content')

<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold mb-6 flex items-center">
            <i class="fas fa-cash-register mr-3"></i> Registrar nueva venta
        </h2>
        <a href="{{ route('ventas.index') }}"
            class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow">
            Listado de Ventas
        </a>
    </div>

    <form action="{{ route('ventas.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label for="codigo" class="block text-gray-700 font-medium mb-2">Código de venta</label>
            <input type="text" name="codigo" id="codigo"
                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                required>
        </div>

        <div id="productos-container">
            <h4 class="font-semibold mt-6 mb-2">Medicamentos</h4>
            <div class="producto-item border p-3 mb-3 rounded bg-gray-50">
                <button type="button" class="btn-eliminar" style="display: none;">×</button>
                <div class="grid grid-cols-6 gap-4">
                    <div>
                        <label>Medicamento</label>
                        <select name="productos[0][medicamento_id]" class="medicamento-select w-full border rounded px-2 py-1" required></select>
                    </div>
                    <div>
                        <label>Cantidad</label>
                        <input type="number" name="productos[0][cantidad]" class="cantidad w-full border rounded px-2 py-1" min="1" required>
                    </div>
                    <div>
                        <label>Precio Unitario</label>
                        <input type="number" step="0.01" name="productos[0][precio_unitario]" class="precio_unitario w-full border rounded px-2 py-1 bg-gray-100" readonly required>
                    </div>
                    <div>
                        <label>Subtotal</label>
                        <input type="number" step="0.01" name="productos[0][subtotal]" class="subtotal w-full border rounded px-2 py-1" readonly required>
                    </div>
                    <div>
                        <label>Descuento</label>
                        <input type="number" step="0.01" name="productos[0][descuento]" class="descuento w-full border rounded px-2 py-1" readonly>
                    </div>
                    <div class="flex flex-col justify-center">
                        <label><input type="checkbox" class="aplicar_descuento"> Aplicar 16%</label>
                    </div>
                </div>
            </div>
        </div>

        <button type="button" id="add-producto" class="mt-2 bg-blue-600 text-white px-4 py-2 rounded">+ Agregar producto</button>
        
        <div class="grid grid-cols-2 gap-4 mt-6">
            <div>
                <label>Subtotal</label>
                <input type="number" step="0.01" name="subtotal" id="subtotal_general" class="w-full px-4 py-2 border rounded-lg" readonly>
            </div>
            <div>
                <label>Impuesto</label>
                <input type="number" step="0.01" name="impuesto" id="impuesto" class="w-full px-4 py-2 border rounded-lg" readonly value="0">
            </div>
            <div>
                <label>Descuento total</label>
                <input type="number" step="0.01" name="descuento" id="descuento_total" class="w-full px-4 py-2 border rounded-lg" readonly>
            </div>
            <div>
                <label>Total</label>
                <input type="number" step="0.01" name="total" id="total_general" class="w-full px-4 py-2 border rounded-lg" readonly>
            </div>
        </div>

        <div class="mt-4">
            <label>Método de pago</label>
            <select name="metodo_pago" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="" disabled selected>Selecciona un método</option>
                <option value="EFECTIVO">Efectivo</option>
                <option value="TRANSFERENCIA">Transferencia</option>
                <option value="TARJETA">Tarjeta</option>
            </select>
        </div>

        <div class="mt-4">
            <label>Observaciones</label>
            <textarea name="observaciones" class="w-full px-4 py-2 border rounded-lg"></textarea>
        </div>

        <div class="mt-6">
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded">Registrar venta</button>
        </div>
    </form>
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
            data: params => ({ q: params.term }),
            processResults: data => ({
                results: data.map(med => ({
                    id: med.id,
                    text: med.nombre,
                    precio: med.precio_venta
                }))
            }),
            cache: true
        }
    }).on('select2:select', function(e) {
        const data = e.params.data;
        const container = $(this).closest('.producto-item');
        container.find('.precio_unitario').val(data.precio);
        const cantidad = parseFloat(container.find('.cantidad').val()) || 0;
        container.find('.subtotal').val((cantidad * data.precio).toFixed(2));
        calcularTotales();
    });
}

function calcularTotales() {
    let subtotal = 0, descuentoTotal = 0;

    $('.producto-item').each(function() {
        const cantidad = parseFloat($(this).find('.cantidad').val()) || 0;
        const precio = parseFloat($(this).find('.precio_unitario').val()) || 0;
        const sub = cantidad * precio;

        $(this).find('.subtotal').val(sub.toFixed(2));

        let descuento = 0;
        if ($(this).find('.aplicar_descuento').is(':checked')) {
            descuento = sub * 0.16;
        }

        $(this).find('.descuento').val(descuento.toFixed(2));

        subtotal += sub;
        descuentoTotal += descuento;
    });

    let total = subtotal - descuentoTotal;

    if (total < 0) total = 0;

    $('#subtotal_general').val(subtotal.toFixed(2));
    $('#impuesto').val('0.00');
    $('#descuento_total').val(descuentoTotal.toFixed(2));
    $('#total_general').val(total.toFixed(2));
}

$(document).ready(function() {
    inicializarSelect2('.medicamento-select');

    let productoIndex = 1;

    $(document).on('input change', '.cantidad, .precio_unitario, .aplicar_descuento', calcularTotales);

    $('#add-producto').on('click', function() {
        const html = `
        <div class="producto-item border p-3 mb-3 rounded bg-gray-50">
            <button type="button" class="btn-eliminar">×</button>
            <div class="grid grid-cols-6 gap-4">
                <div>
                    <label>Medicamento</label>
                    <select name="productos[${productoIndex}][medicamento_id]" class="medicamento-select w-full border rounded px-2 py-1" required></select>
                </div>
                <div>
                    <label>Cantidad</label>
                    <input type="number" name="productos[${productoIndex}][cantidad]" class="cantidad w-full border rounded px-2 py-1" min="1" required>
                </div>
                <div>
                    <label>Precio Unitario</label>
                    <input type="number" step="0.01" name="productos[${productoIndex}][precio_unitario]" class="precio_unitario w-full border rounded px-2 py-1 bg-gray-100" readonly required>
                </div>
                <div>
                    <label>Subtotal</label>
                    <input type="number" step="0.01" name="productos[${productoIndex}][subtotal]" class="subtotal w-full border rounded px-2 py-1" readonly required>
                </div>
                <div>
                    <label>Descuento</label>
                    <input type="number" step="0.01" name="productos[${productoIndex}][descuento]" class="descuento w-full border rounded px-2 py-1" readonly>
                </div>
                <div class="flex flex-col justify-center">
                    <label><input type="checkbox" class="aplicar_descuento"> Aplicar 16%</label>
                </div>
            </div>
        </div>`;
        $('#productos-container').append(html);
        inicializarSelect2(select[name="productos[${productoIndex}][medicamento_id]"]);
        productoIndex++;
    });

    $(document).on('click', '.btn-eliminar', function() {
        $(this).closest('.producto-item').remove();
        calcularTotales();
        
        // Si solo queda un producto, ocultar el botón de eliminar del primero
        if ($('.producto-item').length === 1) {
            $('.producto-item .btn-eliminar').hide();
        }
    });

    // Ocultar el botón de eliminar del primer producto al cargar la página
    $('.producto-item .btn-eliminar').first().hide();
});
</script>

@endsection
