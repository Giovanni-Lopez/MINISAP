@extends('layouts.app')

@section('titulo', 'Historial de Combustible')

@section('contenido')
<div class="w-full px-4 sm:px-6 py-6">
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 sm:p-6 shadow-2xl w-full">
        
        {{-- Mensaje de Éxito --}}
        @if(session('exito'))
            <div class="mb-4 p-4 bg-emerald-900/40 border border-emerald-500/50 rounded-xl text-emerald-300 text-sm flex items-center justify-between">
                <span class="flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-400"></i> {{ session('exito') }}
                </span>
                <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-200 text-xs font-bold">&times;</button>
            </div>
        @endif

        {{-- Encabezado --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 pb-4 border-b border-gray-800">
            <div>
                <h2 class="text-xl font-extrabold text-white flex items-center gap-2">
                    <i class="fa-solid fa-gas-pump text-red-500"></i> Historial de Cargas de Combustible
                </h2>
                <p class="text-xs text-gray-400 mt-1">Registros de combustible enviados por las sucursales.</p>
            </div>
            <div>
                <a href="{{ route('combustible.index') }}" class="inline-flex items-center justify-center gap-2 bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 px-5 rounded-xl text-xs transition shadow-lg shadow-red-900/30">
                    <i class="fa-solid fa-plus"></i> Nueva Carga
                </a>
            </div>
        </div>

        {{-- VISTA CELULAR (Solo visible en pantallas < 1024px) --}}
        <div class="space-y-3 block lg:hidden">
            @forelse($registros as $row)
                <div class="bg-gray-800/80 border border-gray-700/60 rounded-xl p-4 shadow-md">
                    <div class="flex justify-between items-start mb-3 border-b border-gray-700/50 pb-2">
                        <div>
                            <span class="text-[10px] font-mono font-bold text-red-400 uppercase tracking-wider">Vale #{{ $row->no_vale }}</span>
                            <h4 class="text-sm font-bold text-white">{{ $row->sucursal }}</h4>
                        </div>
                        <span class="text-emerald-400 font-bold font-mono text-base">${{ number_format($row->total_carga, 2) }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-2 text-xs mb-3">
                        <div>
                            <span class="text-gray-500 block text-[10px] uppercase">Fecha</span>
                            <span class="text-gray-300 font-mono">{{ $row->fecha }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block text-[10px] uppercase">Placa</span>
                            <span class="text-white font-bold">{{ $row->placa }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block text-[10px] uppercase">Usuario</span>
                            <span class="text-gray-300 truncate block">{{ $row->usuario }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block text-[10px] uppercase">Consumo</span>
                            <span class="text-gray-300 font-mono">{{ $row->galonaje }} gal</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block text-[10px] uppercase">Tipo Gasolina</span>
                            <span class="text-gray-300">{{ $row->tipo_gas }}</span>
                        </div>
                        <div>
                            <span class="text-gray-500 block text-[10px] uppercase">Kilometraje</span>
                            <span class="text-gray-300 font-mono">{{ number_format($row->kilometraje) }} km</span>
                        </div>
                    </div>

                    {{-- Acciones Móvil --}}
                    <div class="flex justify-end gap-2 pt-2 border-t border-gray-700/40">
                        <button type="button" onclick="abrirModalEditar({{ json_encode($row) }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-950/60 hover:bg-blue-900 border border-blue-800 text-blue-400 rounded-lg text-xs font-semibold transition">
                            <i class="fa-solid fa-pen-to-square"></i> Editar
                        </button>
                        <form action="{{ route('combustible.destroy', $row->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este registro?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-950/60 hover:bg-red-900 border border-red-800 text-red-400 rounded-lg text-xs font-semibold transition">
                                <i class="fa-solid fa-trash-can"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center py-8 text-gray-500 bg-gray-800/40 rounded-xl border border-gray-800">
                    <i class="fa-solid fa-folder-open text-2xl mb-2 block"></i>
                    No hay registros de combustible guardados aún.
                </div>
            @endforelse
        </div>

        {{-- VISTA ESCRITORIO (Solo visible en PC >= 1024px) --}}
        <div class="hidden lg:block overflow-x-auto w-full">
            <table class="w-full text-sm text-left text-gray-300">
                <thead class="text-xs uppercase bg-gray-800 text-gray-400 font-mono border-b border-gray-700">
                    <tr>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Sucursal</th>
                        <th class="px-4 py-3">N° Vale</th>
                        <th class="px-4 py-3">Placa</th>
                        <th class="px-4 py-3">Usuario</th>
                        <th class="px-4 py-3">Tipo Gas</th>
                        <th class="px-4 py-3">KM</th>
                        <th class="px-4 py-3">Área</th>
                        <th class="px-4 py-3">Galones</th>
                        <th class="px-4 py-3">Precio/Gal</th>
                        <th class="px-4 py-3 text-right">Total ($)</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                    @forelse($registros as $row)
                        <tr class="hover:bg-gray-800/50 transition">
                            <td class="px-4 py-3 text-gray-400 font-mono text-xs whitespace-nowrap">{{ $row->fecha }}</td>
                            <td class="px-4 py-3 font-semibold text-white whitespace-nowrap">{{ $row->sucursal }}</td>
                            <td class="px-4 py-3 font-mono text-xs text-red-400 whitespace-nowrap">#{{ $row->no_vale }}</td>
                            <td class="px-4 py-3 font-bold text-gray-200 whitespace-nowrap">{{ $row->placa }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">{{ $row->usuario }}</td>
                            <td class="px-4 py-3 whitespace-nowrap"><span class="bg-gray-800 border border-gray-700 px-2 py-0.5 rounded text-xs text-gray-300">{{ $row->tipo_gas }}</span></td>
                            <td class="px-4 py-3 font-mono text-xs whitespace-nowrap">{{ number_format($row->kilometraje) }} km</td>
                            <td class="px-4 py-3 text-xs text-gray-400 whitespace-nowrap">{{ $row->area }}</td>
                            <td class="px-4 py-3 font-mono whitespace-nowrap">{{ $row->galonaje }} gal</td>
                            <td class="px-4 py-3 font-mono text-xs whitespace-nowrap">${{ number_format($row->precio_galon, 2) }}</td>
                            <td class="px-4 py-3 text-emerald-400 font-bold text-right font-mono whitespace-nowrap">${{ number_format($row->total_carga, 2) }}</td>
                            <td class="px-4 py-3 text-center whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Botón Editar que activa el Modal --}}
                                    <button type="button" onclick="abrirModalEditar({{ json_encode($row) }})" class="text-blue-400 hover:text-blue-300 p-1.5 bg-blue-950/50 hover:bg-blue-900 border border-blue-800 rounded-lg transition" title="Editar">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    {{-- Botón Eliminar --}}
                                    <form action="{{ route('combustible.destroy', $row->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este registro?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 p-1.5 bg-red-950/50 hover:bg-red-900 border border-red-800 rounded-lg transition" title="Eliminar">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center py-8 text-gray-500">
                                <i class="fa-solid fa-folder-open text-2xl mb-2 block"></i>
                                No hay registros de combustible guardados aún.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $registros->links() }}
        </div>

    </div>
</div>

{{-- MODAL EMERGENTE DE EDICIÓN --}}
<div id="modalEditar" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-gray-900 border border-gray-800 rounded-2xl w-full max-w-lg p-5 shadow-2xl relative max-h-[90vh] overflow-y-auto">
        
        <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-800">
            <h3 class="text-base font-bold text-white flex items-center gap-2">
                <i class="fa-solid fa-pen-to-square text-blue-500"></i> Editar Carga de Combustible
            </h3>
            <button type="button" onclick="cerrarModalEditar()" class="text-gray-400 hover:text-white text-lg font-bold px-2">&times;</button>
        </div>

        <form id="formEditarCombustible" method="POST" class="space-y-3">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-[11px] font-medium text-gray-400 mb-1">Sucursal</label>
                    <input type="text" id="edit_sucursal" name="sucursal" required class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl p-2 text-xs focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-[11px] font-medium text-gray-400 mb-1">Fecha</label>
                    <input type="date" id="edit_fecha" name="fecha" required class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl p-2 text-xs focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-[11px] font-medium text-gray-400 mb-1">N° Vale</label>
                    <input type="number" id="edit_no_vale" name="no_vale" required class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl p-2 text-xs focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-[11px] font-medium text-gray-400 mb-1">Placa</label>
                    <input type="text" id="edit_placa" name="placa" required class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl p-2 text-xs focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-[11px] font-medium text-gray-400 mb-1">Usuario</label>
                    <input type="text" id="edit_usuario" name="usuario" required class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl p-2 text-xs focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-[11px] font-medium text-gray-400 mb-1">Área</label>
                    <input type="text" id="edit_area" name="area" required class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl p-2 text-xs focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-[11px] font-medium text-gray-400 mb-1">Tipo Gasolina</label>
                    <input type="text" id="edit_tipo_gas" name="tipo_gas" required class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl p-2 text-xs focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-[11px] font-medium text-gray-400 mb-1">Kilometraje</label>
                    <input type="number" id="edit_kilometraje" name="kilometraje" required class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl p-2 text-xs focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-[11px] font-medium text-gray-400 mb-1">Precio / Galón ($)</label>
                    <input type="number" step="0.01" id="edit_precio_galon" name="precio_galon" required class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl p-2 text-xs focus:outline-none focus:border-blue-500">
                </div>

                <div>
                    <label class="block text-[11px] font-medium text-gray-400 mb-1">Galones</label>
                    <input type="number" step="0.001" id="edit_galonaje" name="galonaje" required class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl p-2 text-xs focus:outline-none focus:border-blue-500">
                </div>
            </div>

            <div class="flex justify-end gap-2 mt-5 pt-3 border-t border-gray-800">
                <button type="button" onclick="cerrarModalEditar()" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 rounded-xl text-xs font-bold transition">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT PARA CONTROLAR EL MODAL --}}
<script>
    function abrirModalEditar(registro) {
        const form = document.getElementById('formEditarCombustible');
        form.action = `/combustible/${registro.id}`;

        document.getElementById('edit_sucursal').value = registro.sucursal;
        document.getElementById('edit_fecha').value = registro.fecha;
        document.getElementById('edit_no_vale').value = registro.no_vale;
        document.getElementById('edit_placa').value = registro.placa;
        document.getElementById('edit_usuario').value = registro.usuario;
        document.getElementById('edit_area').value = registro.area;
        document.getElementById('edit_tipo_gas').value = registro.tipo_gas;
        document.getElementById('edit_kilometraje').value = registro.kilometraje;
        document.getElementById('edit_precio_galon').value = registro.precio_galon;
        document.getElementById('edit_galonaje').value = registro.galonaje;

        document.getElementById('modalEditar').classList.remove('hidden');
    }

    function cerrarModalEditar() {
        document.getElementById('modalEditar').classList.add('hidden');
    }
</script>
@endsection