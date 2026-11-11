<div class="overflow-x-auto w-full">
    <table class="w-full text-sm text-left text-gray-300">
        <thead class="text-xs uppercase bg-gray-800 text-gray-400 font-mono border-b border-gray-700">
            <tr>
                <th class="px-4 py-3">Fecha Resolución</th>
                <th class="px-4 py-3">Vehículo / Área</th>
                <th class="px-4 py-3">Reporte Original</th>
                <th class="px-4 py-3">Solución Aplicada</th>
                <th class="px-4 py-3 text-center">Estado</th>
                <th class="px-4 py-3 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-800">
            @forelse($datos as $row)
                <tr class="hover:bg-gray-800/50 transition">
                    <td class="px-4 py-3 text-gray-400 font-mono text-xs">
                        {{ $row->updated_at ? $row->updated_at->format('Y-m-d H:i') : 'N/D' }}
                    </td>
                    <td class="px-4 py-3 font-semibold text-white">{{ $row->vehiculo ?? $row->sucursal ?? 'General' }}</td>
                    <td class="px-4 py-3 text-xs text-gray-300 max-w-xs truncate">{{ $row->descripcion }}</td>
                    <td class="px-4 py-3 text-xs text-emerald-300 max-w-xs truncate">{{ $row->comentarios ?? $row->solucion ?? 'Finalizado sin observaciones' }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="bg-emerald-950/60 border border-emerald-800 text-emerald-400 px-2.5 py-1 rounded-lg text-xs font-bold">
                            {{ $row->estado }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-center whitespace-nowrap">
                        <div class="flex items-center justify-center gap-2">
                            <button type="button" onclick="abrirModalReabrir({{ json_encode($row) }})" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-950/60 hover:bg-amber-900 border border-amber-800 text-amber-400 rounded-lg text-xs font-semibold transition" title="Regresar al Muro / Observaciones">
                                <i class="fa-solid fa-rotate-left"></i> Reabrir
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-circle-check text-2xl mb-2 block text-gray-600"></i>
                        No hay revisiones ni incidencias finalizadas registradas.
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

{{-- MODAL EMERGENTE PARA REABRIR O AGREGAR OBSERVACIONES --}}
<div id="modalReabrir" class="fixed inset-0 z-50 hidden bg-black/80 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="bg-gray-900 border border-gray-800 rounded-2xl w-full max-w-lg p-5 shadow-2xl relative">
        
        <div class="flex justify-between items-center mb-4 pb-3 border-b border-gray-800">
            <h3 class="text-base font-bold text-white flex items-center gap-2">
                <i class="fa-solid fa-rotate-left text-amber-500"></i> Regresar Incidencia a Proceso
            </h3>
            <button type="button" onclick="cerrarModalReabrir()" class="text-gray-400 hover:text-white text-lg font-bold">&times;</button>
        </div>

        <form id="formReabrirIncidencia" method="POST" class="space-y-3">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-[11px] font-medium text-gray-400 mb-1">Mover al Estado</label>
                <select name="estado" class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl p-2 text-xs focus:outline-none focus:border-amber-500">
                    <option value="En Revisión">En Revisión (Regresar al Muro)</option>
                    <option value="Pendiente">Pendiente</option>
                </select>
            </div>

            <div>
                <label class="block text-[11px] font-medium text-gray-400 mb-1">Nuevas Observaciones / Motivo de reapertura</label>
                <textarea name="comentarios" rows="3" placeholder="Escribe las nuevas observaciones para el equipo..." class="w-full bg-gray-800 border border-gray-700 text-white rounded-xl p-2 text-xs focus:outline-none focus:border-amber-500"></textarea>
            </div>

            <div class="flex justify-end gap-2 mt-5 pt-3 border-t border-gray-800">
                <button type="button" onclick="cerrarModalReabrir()" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 rounded-xl text-xs font-bold transition">Cancelar</button>
                <button type="submit" class="px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-bold transition">Actualizar y Enviar al Muro</button>
            </div>
        </form>
    </div>
</div>

<script>
    function abrirModalReabrir(row) {
        const form = document.getElementById('formReabrirIncidencia');
        form.action = `/incidencias/${row.id}/actualizar`;
        document.getElementById('modalReabrir').classList.remove('hidden');
    }

    function cerrarModalReabrir() {
        document.getElementById('modalReabrir').classList.add('hidden');
    }
</script>