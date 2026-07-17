@extends('layouts.app')

@section('titulo', 'Registro de Combustible')

@section('contenido')
<div class="max-w-3xl w-full">
    @if(session('exito'))
        <div class="bg-emerald-950 border border-emerald-500 text-emerald-300 p-4 rounded-xl text-sm flex items-center gap-2 mb-6 shadow-lg">
            <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i> {{ session('exito') }}
        </div>
    @endif

    <div class="bg-gray-900 border border-gray-800 p-8 rounded-2xl shadow-2xl">
        <div class="mb-6 border-b border-gray-800 pb-4">
            <h2 class="text-xl font-extrabold text-white flex items-center gap-2">
                <i class="fa-solid fa-gas-pump text-red-500"></i> Registro de Combustible
            </h2>
            <p class="text-xs text-gray-400 mt-1">Llena con precisión los datos del ticket de carga de combustible de la unidad.</p>
        </div>

        <!-- Agregamos un ID al formulario para controlarlo con JavaScript -->
        <form id="combustible-form" action="{{ route('combustible.store') }}" method="POST" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">1. Sucursal *</label>
                    <select name="sucursal" id="sucursal-select" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                        <option value="">Seleccione la respuesta</option>
                        @foreach($sucursalesConPlacas as $nombreSucursal => $placas)
                            <option value="{{ $nombreSucursal }}">{{ $nombreSucursal }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">2. Fecha *</label>
                    <input type="date" name="fecha" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">3. N° Vale *</label>
                    <input type="number" name="no_vale" min="1" placeholder="Escribe un número mayor o igual a 1" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">4. Placa *</label>
                    <select name="placa" id="placa-select" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                        <option value="">Seleccione primero una sucursal...</option>
                    </select>
                    <input type="text" name="placa_manual" id="placa-manual-input" placeholder="Escribe la placa manualmente (Ej: C-999999)" class="hidden w-full bg-gray-800 border border-amber-500/50 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-500 transition shadow-inner mt-2 uppercase">
                </div>
            </div>

            <div>
                <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">5. Usuario *</label>
                <select name="usuario" id="usuario-select" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                    <option value="">Seleccione primero una sucursal...</option>
                </select>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">6. Precio Galón *</label>
                    <input type="number" step="0.01" id="precio_galon" name="precio_galon" placeholder="El valor debe ser un número" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">7. Galonaje *</label>
                    <input type="number" step="0.01" id="galonaje" name="galonaje" placeholder="El valor debe ser un número" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                </div>
            </div>

            <div class="bg-gray-950 p-5 rounded-xl border border-gray-800 flex items-center justify-between">
                <div>
                    <h4 class="text-xs font-mono uppercase tracking-wider text-gray-400">Total de Carga / Cobro</h4>
                    <p class="text-xs text-gray-500 mt-0.5">(Calculado en tiempo real: Precio × Galonaje)</p>
                </div>
                <div class="text-right">
                    <span class="text-xs font-mono text-emerald-400 mr-0.5">$</span>
                    <span id="total-pago-display" class="text-3xl font-black text-emerald-400 tracking-tight">0.00</span>
                </div>
            </div>

            <div>
                <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-3">8. Tipo Gas *</label>
                <div class="space-y-2 bg-gray-800/40 p-4 rounded-xl border border-gray-800">
                    <label class="flex items-center gap-3 cursor-pointer group text-sm">
                        <input type="radio" name="tipo_gas" value="Especial" required class="accent-red-500 h-4 w-4">
                        <span class="text-gray-300 group-hover:text-white transition">ESPECIAL</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group text-sm">
                        <input type="radio" name="tipo_gas" value="Regular" class="accent-red-500 h-4 w-4">
                        <span class="text-gray-300 group-hover:text-white transition">REGULAR</span>
                    </label>
                    <label class="flex items-center gap-3 cursor-pointer group text-sm">
                        <input type="radio" name="tipo_gas" value="Diesel" class="accent-red-500 h-4 w-4">
                        <span class="text-gray-300 group-hover:text-white transition">DIESEL</span>
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">9. Kilometraje *</label>
                    <input type="number" name="kilometraje" placeholder="El valor debe ser un número" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">10. Área *</label>
                    <select name="area" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                        <option value="">Selecciona la respuesta</option>
                        <option value="Despacho">DESPACHO</option>
                        <option value="Distribución">DISTRIBUCION</option>
                        <option value="Operaciones">OPERACIONES</option>
                        <option value="Otros">OTROS</option>
                        <option value="Ventas">VENTAS</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3.5 px-4 rounded-xl transition flex items-center justify-center gap-2 text-sm shadow-lg shadow-red-900/30 mt-4 cursor-pointer">
                <i class="fa-solid fa-floppy-disk"></i> Guardar Registro de Combustible
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const datosFlota = @json($sucursalesConPlacas);
    const datosUsuarios = @json($usuariosPorSucursal);

    const formulario = document.getElementById('combustible-form');
    const sucursalSelect = document.getElementById('sucursal-select');
    const placaSelect = document.getElementById('placa-select');
    const placaManualInput = document.getElementById('placa-manual-input');
    const usuarioSelect = document.getElementById('usuario-select');

    sucursalSelect.addEventListener('change', function() {
        const sucursalSeleccionada = this.value;

        placaManualInput.classList.add('hidden');
        placaManualInput.removeAttribute('required');
        placaManualInput.value = '';

        placaSelect.innerHTML = '<option value="">Seleccione una placa...</option>';
        if (sucursalSeleccionada && datosFlota[sucursalSeleccionada]) {
            datosFlota[sucursalSeleccionada].forEach(placa => {
                const option = document.createElement('option');
                option.value = placa;
                option.textContent = placa;
                placaSelect.appendChild(option);
            });
            
            const optionOtro = document.createElement('option');
            optionOtro.value = 'OTRO';
            optionOtro.textContent = '➕ OTRO (Ingresar manualmente)';
            placaSelect.appendChild(optionOtro);
        } else {
            placaSelect.innerHTML = '<option value="">Seleccione primero una sucursal...</option>';
        }

        usuarioSelect.innerHTML = '<option value="">Seleccione un Conductor...</option>';
        if (sucursalSeleccionada && datosUsuarios[sucursalSeleccionada]) {
            datosUsuarios[sucursalSeleccionada].forEach(usuario => {
                const option = document.createElement('option');
                option.value = usuario;
                option.textContent = usuario;
                usuarioSelect.appendChild(option);
            });
        } else {
            usuarioSelect.innerHTML = '<option value="">Seleccione primero una sucursal...</option>';
        }
    });

    placaSelect.addEventListener('change', function() {
        if (this.value === 'OTRO') {
            placaManualInput.classList.remove('hidden');
            placaManualInput.setAttribute('required', 'required');
            placaManualInput.focus();
        } else {
            placaManualInput.classList.add('hidden');
            placaManualInput.removeAttribute('required');
            placaManualInput.value = '';
        }
    });

    // CORRECCIÓN CLAVE: Interceptamos el envío para mandar la placa manual si se seleccionó "OTRO"
    formulario.addEventListener('submit', function(e) {
        if (placaSelect.value === 'OTRO') {
            const valorManual = placaManualInput.value.trim().toUpperCase();
            if (valorManual !== '') {
                // Cambiamos temporalmente el valor del select para que viaje el texto escrito a mano
                placaSelect.options[placaSelect.selectedIndex].value = valorManual;
            }
        }
    });

    const precioInput = document.getElementById('precio_galon');
    const galonajeInput = document.getElementById('galonaje');
    const totalPagoDisplay = document.getElementById('total-pago-display');

    function calcularTotalCombustible() {
        const precio = parseFloat(precioInput.value) || 0;
        const galonaje = parseFloat(galonajeInput.value) || 0;
        
        const total = precio * galonaje;
        totalPagoDisplay.textContent = total.toFixed(2);
    }

    precioInput.addEventListener('input', calcularTotalCombustible);
    galonajeInput.addEventListener('input', calcularTotalCombustible);
</script>
@endpush