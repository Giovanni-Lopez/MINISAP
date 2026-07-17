@extends('layouts.app')

@section('titulo', 'Panel de Checklist')

@section('contenido')
<div class="flex justify-center items-center min-h-[70vh] w-full">
    <div class="max-w-xl w-full">
        @if(session('exito'))
            <div class="bg-emerald-950 border border-emerald-500 text-emerald-300 p-4 rounded-xl text-sm flex items-center gap-2 mb-6 shadow-lg">
                <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i> {{ session('exito') }}
            </div>
        @endif

        <div class="bg-gray-900 border border-gray-800 p-8 rounded-2xl shadow-2xl">
            <div class="mb-6">
                <h2 class="text-xl font-extrabold text-white flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square text-red-500"></i> Registrar Nueva Incidencia
                </h2>
                <p class="text-xs text-gray-400 mt-1">Reporta problemas logísticos, fallas en sucursales o trabas operativas inmediatamente.</p>
            </div>

            <form action="{{ route('incidencias.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Sucursal Afectada</label>
                    <select name="sucursal" id="sucursal-select" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                        <option value="">Seleccione Sucursal...</option>
                        @foreach($sucursalesConPlacas as $nombreSucursal => $placas)
                            <option value="{{ $nombreSucursal }}">{{ $nombreSucursal }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Placa del Vehículo (Opcional)</label>
                    <select name="placa" id="placa-select" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                        <option value="">Seleccione primero una sucursal...</option>
                    </select>
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
                    <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Descripción del Problema</label>
                    <textarea name="descripcion" rows="4" required placeholder="Describe detalladamente el problema con la carga, equipo o retraso..." class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition placeholder-gray-600 shadow-inner resize-none"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Evidencia Fotográfica (Opcional)</label>
                    <input type="file" name="imagen_evidencia" accept="image/*" class="w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-gray-800 file:text-gray-200 hover:file:bg-gray-700 file:transition cursor-pointer">
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
    const datosFlota = @json($sucursalesConPlacas);
    const sucursalSelect = document.getElementById('sucursal-select');
    const placaSelect = document.getElementById('placa-select');

    if (sucursalSelect && placaSelect) {
        sucursalSelect.addEventListener('change', function() {
            const sucursalSeleccionada = this.value;
            placaSelect.innerHTML = '<option value="">Ninguno / No aplica</option>';
            
            if (sucursalSeleccionada && datosFlota[sucursalSeleccionada]) {
                datosFlota[sucursalSeleccionada].forEach(placa => {
                    const option = document.createElement('option');
                    option.value = placa;
                    option.textContent = placa;
                    placaSelect.appendChild(option);
                });
            }
        });
    }
</script>
@endpush