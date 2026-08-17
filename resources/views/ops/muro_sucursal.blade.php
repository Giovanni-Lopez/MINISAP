@extends('layouts.app')

@section('titulo', 'Panel de Checklist')

@section('contenido')
<div class="flex justify-center items-center min-h-[70vh] w-full my-6">
    <div class="max-w-xl w-full">
        @if(session('exito'))
            <div class="bg-emerald-950 border border-emerald-500 text-emerald-300 p-4 rounded-xl text-sm flex items-center gap-2 mb-6 shadow-lg">
                <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i> {{ session('exito') }}
            </div>
        @endif

        <div class="bg-gray-900 border border-gray-800 p-8 rounded-2xl shadow-2xl">
            <div class="mb-6">
                <h2 class="text-xl font-extrabold text-white flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-red-500"></i> Registrar Nueva Incidencia / Checklist
                </h2>
                <p class="text-xs text-gray-400 mt-1">Reporta problemas logísticos, revisiones de unidades o trabas operativas.</p>
            </div>

            <form action="{{ route('incidencias.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                {{-- FECHA DE REGISTRO (BLOQUEADA EN EL DÍA ACTUAL) --}}
                <div>
                    <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Fecha del Registro (Actual)</label>
                    <input type="date" name="fecha" value="{{ date('Y-m-d') }}" readonly class="w-full bg-gray-900 border border-gray-800 text-gray-400 rounded-xl px-4 py-3 text-sm cursor-not-allowed focus:outline-none select-none">
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Sucursal Afectada</label>
                    <select name="sucursal" id="sucursal-select" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                        <option value="">Seleccione Sucursal...</option>
                        @foreach($sucursalesConPlacas as $nombreSucursal => $vehiculos)
                            <option value="{{ $nombreSucursal }}">{{ $nombreSucursal }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Placa del Vehículo / Moto (Opcional)</label>
                    <select name="placa" id="placa-select" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                        <option value="">Seleccione primero una sucursal...</option>
                    </select>
                </div>

                {{-- REVISIONES DIARIAS (CHECKBOXES DINÁMICOS) --}}
                <div class="bg-gray-800/60 border border-gray-700/80 rounded-xl p-4 space-y-3">
                    <label class="block text-xs font-mono uppercase tracking-wider text-red-400 font-semibold">Puntos de Revisión Diaria (Seleccionar)</label>
                    
                    <div class="grid grid-cols-2 gap-2 text-xs text-gray-300">
                        <label class="flex items-center gap-2 cursor-pointer bg-gray-800/80 p-2 rounded-lg hover:bg-gray-700/50 transition">
                            <input type="checkbox" name="revisiones[]" value="Nivel de Aceite" class="rounded border-gray-700 bg-gray-900 text-red-600 focus:ring-red-500">
                            <span>Nivel de Aceite</span>
                        </label>

                        <label class="flex items-center gap-2 cursor-pointer bg-gray-800/80 p-2 rounded-lg hover:bg-gray-700/50 transition">
                            <input type="checkbox" name="revisiones[]" value="Presión de Llantas" class="rounded border-gray-700 bg-gray-900 text-red-600 focus:ring-red-500">
                            <span>Presión de Llantas</span>
                        </label>

                        <label class="flex items-center gap-2 cursor-pointer bg-gray-800/80 p-2 rounded-lg hover:bg-gray-700/50 transition">
                            <input type="checkbox" name="revisiones[]" value="Frenos y Luces" class="rounded border-gray-700 bg-gray-900 text-red-600 focus:ring-red-500">
                            <span>Frenos y Luces</span>
                        </label>

                        {{-- CHECKBOX DINÁMICO (CAMBIA SEGÚN EL TIPO DE UNIDAD) --}}
                        <label class="flex items-center gap-2 cursor-pointer bg-gray-800/80 p-2 rounded-lg hover:bg-gray-700/50 transition">
                            <input type="checkbox" id="dynamic-check-input" name="revisiones[]" value="Llanta de Repuesto" class="rounded border-gray-700 bg-gray-900 text-red-600 focus:ring-red-500">
                            <span id="dynamic-check-text">Llanta de Repuesto</span>
                        </label>

                        <label class="flex items-center gap-2 cursor-pointer bg-gray-800/80 p-2 rounded-lg hover:bg-gray-700/50 transition">
                            <input type="checkbox" name="revisiones[]" value="Espejos / Retrovisores" class="rounded border-gray-700 bg-gray-900 text-red-600 focus:ring-red-500">
                            <span>Espejos / Retrovisores</span>
                        </label>

                        <label class="flex items-center gap-2 cursor-pointer bg-gray-800/80 p-2 rounded-lg hover:bg-gray-700/50 transition">
                            <input type="checkbox" name="revisiones[]" value="Nivel de Combustible" class="rounded border-gray-700 bg-gray-900 text-red-600 focus:ring-red-500">
                            <span>Nivel Combustible</span>
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Nivel de Urgencia</label>
                    <select name="urgencia" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                        <option value="Baja">🟢 Baja (Afectación mínima)</option>
                        <option value="Media" selected>🟡 Media (Afectación parcial)</option>
                        <option value="Alta">🟠 Alta (Traba operativa grave)</option>
                        <option value="Crítica">🔴 Crítica (Operación detenida)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Descripción del Problema / Observaciones</label>
                    <textarea name="descripcion" rows="4" required placeholder="Describe detalladamente las fallas encontradas o la revisión realizada..." class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition placeholder-gray-600 shadow-inner resize-none"></textarea>
                </div>

                {{-- EVIDENCIA FOTOGRÁFICA --}}
                <div>
                    <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Evidencia Fotográfica (Cámara)</label>
                    <input type="file" name="imagen_evidencia" accept="image/*" capture="environment" class="w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-gray-800 file:text-gray-200 hover:file:bg-gray-700 file:transition cursor-pointer">
                </div>

                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3.5 px-4 rounded-xl transition flex items-center justify-center gap-2 text-sm shadow-lg shadow-red-900/30 cursor-pointer">
                    <i class="fa-solid fa-paper-plane"></i> Publicar Reporte en el Muro
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const datosFlota = @json($sucursalesConPlacas);
        const sucursalSelect = document.getElementById('sucursal-select');
        const placaSelect = document.getElementById('placa-select');
        const dynamicCheckInput = document.getElementById('dynamic-check-input');
        const dynamicCheckText = document.getElementById('dynamic-check-text');

        function adaptarRevisionSegunUnidad() {
            const placaVal = placaSelect.value;
            const textoSeleccionado = placaSelect.options[placaSelect.selectedIndex]?.text || '';

            const esMoto = placaVal.toUpperCase().startsWith('M') || 
                           textoSeleccionado.toLowerCase().includes('yamaha') || 
                           textoSeleccionado.toLowerCase().includes('moto');

            if (esMoto) {
                dynamicCheckInput.value = "Cadena / Transmisión";
                dynamicCheckText.textContent = "Cadena / Transmisión";
            } else {
                dynamicCheckInput.value = "Llanta de Repuesto";
                dynamicCheckText.textContent = "Llanta de Repuesto";
            }
        }

        function actualizarPlacas() {
            const sucursalSeleccionada = sucursalSelect.value;
            
            placaSelect.innerHTML = '';

            if (!sucursalSeleccionada) {
                placaSelect.innerHTML = '<option value="">Seleccione primero una sucursal...</option>';
                adaptarRevisionSegunUnidad();
                return;
            }

            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Ninguno / No aplica';
            placaSelect.appendChild(defaultOption);

            if (datosFlota[sucursalSeleccionada] && datosFlota[sucursalSeleccionada].length > 0) {
                datosFlota[sucursalSeleccionada].forEach(v => {
                    const option = document.createElement('option');
                    option.value = v.placa;
                    option.textContent = v.texto;
                    placaSelect.appendChild(option);
                });
            }

            adaptarRevisionSegunUnidad();
        }

        if (sucursalSelect && placaSelect) {
            sucursalSelect.addEventListener('change', actualizarPlacas);
            placaSelect.addEventListener('change', adaptarRevisionSegunUnidad);
            
            if (sucursalSelect.value) {
                actualizarPlacas();
            }
        }
    });
</script>
@endpush