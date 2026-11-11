<div class="overflow-x-auto w-full">
    <table class="w-full text-sm text-left text-gray-300">
        <thead class="text-xs uppercase bg-gray-800 text-gray-400 font-mono border-b border-gray-700">
            <tr>
                <th class="px-4 py-3">Fecha</th>
                <th class="px-4 py-3">Vehículo (Placa)</th>
                <th class="px-4 py-3">Motorista</th>
                <th class="px-4 py-3">KM Inicial</th>
                <th class="px-4 py-3">KM Final</th>
                <th class="px-4 py-3 text-right">Total Recorrido</th>
                <th class="px-4 py-3 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-800">
            @forelse($datos as $row)
                <tr class="hover:bg-gray-800/50 transition">
                    <td class="px-4 py-3 text-gray-400 font-mono text-xs">{{ $row->fecha ?? ($row->created_at ? $row->created_at->format('Y-m-d') : 'N/D') }}</td>
                    <td class="px-4 py-3 font-bold text-white">{{ $row->placa ?? ($row->vehiculo->placa ?? 'N/D') }}</td>
                    <td class="px-4 py-3">{{ $row->motorista ?? ($row->conductor->nombre ?? 'N/D') }}</td>
                    <td class="px-4 py-3 font-mono text-xs text-gray-400">{{ number_format($row->km_inicial ?? 0) }} km</td>
                    <td class="px-4 py-3 font-mono text-xs text-gray-400">{{ number_format($row->km_final ?? 0) }} km</td>
                    <td class="px-4 py-3 text-emerald-400 font-bold text-right font-mono">{{ number_format(($row->km_final ?? 0) - ($row->km_inicial ?? 0)) }} km</td>
                    <td class="px-4 py-3 text-center whitespace-nowrap">
                        <div class="flex items-center justify-center gap-2">
                            <button type="button" onclick="abrirModalKm({{ json_encode($row) }})" class="text-blue-400 hover:text-blue-300 p-1.5 bg-blue-950/50 hover:bg-blue-900 border border-blue-800 rounded-lg transition" title="Editar KM Final">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-road text-2xl mb-2 block text-gray-600"></i>
                        No hay registros de kilometraje diario guardados aún.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    @if(method_exists($datos, 'links'))
        {{ $datos->links() }}
    @endif
</div>

{{-- MODAL EMERGENTE DE EDICIÓN (KM INICIAL BLOQUEADO) --}}
<div id="modalEditarKm" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-gray-900 border border-gray-800 rounded-2xl w-full max-w-md p-5 shadow-2xl relative">
        
        <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-800">
            <h3 class="text-base font-bold text-white flex items-center gap-2">
                <i class="fa-solid fa-gauge text-blue-500"></i> Actualizar KM Final de Ruta
            </h3>
            <button type="button" onclick="cerrarModalKm()" class="text-gray-400 hover:text-white text-lg font-bold">&times;</button>
        </div>

        <form id="formEditarKm" method="POST" class="space-y-3">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-[11px] font-medium text-gray-400 mb-1">Placa del Vehículo</label>
                <input type="text" id="km_placa" readonly class="w-full bg-gray-800/50 border border-gray-700 text-gray-400 rounded-xl p-2 text-xs cursor-not-allowed">
            </div>

            <div>
                <label class="block text-[11px] font-medium text-gray-400 mb-1">KM Inicial (Bloqueado por seguridad)</label>
                <input type="number" id="km_inicial" name="km_inicial" readonly class="w-full bg-gray-800/40 border border-gray-700/60 text-gray-400 rounded-xl p-2 text-xs cursor-not-allowed font-mono">
                <span class="text-[10px] text-gray-500 mt-0.5 block">Este valor ya fue fijado al iniciar el recorrido.</span>
            </div>

            <div>
                <label class="block text-[11px] font-medium text-blue-400 mb-1">KM Final (Habilitado para actualización)</label>
                <input type="number" id="km_final" name="km_final" required class="w-full bg-gray-800 border border-blue-500/60 text-white rounded-xl p-2 text-xs focus:outline-none focus:border-blue-400 font-mono">
            </div>

            <div class="flex justify-end gap-2 mt-5 pt-3 border-t border-gray-800">
                <button type="button" onclick="cerrarModalKm()" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 rounded-xl text-xs font-bold transition">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition">Guardar KM Final</button>
            </div>
        </form>
    </div>
</div>

<script>
    function abrirModalKm(row) {
        const form = document.getElementById('formEditarKm');
        form.action = `/km-diarios/${row.id}`;
        document.getElementById('km_placa').value = row.placa || 'N/D';
        document.getElementById('km_inicial').value = row.km_inicial;
        document.getElementById('km_final').value = row.km_final;
        document.getElementById('modalEditarKm').classList.remove('hidden');
    }

    function cerrarModalKm() {
        document.getElementById('modalEditarKm').classList.add('hidden');
    }
</script>