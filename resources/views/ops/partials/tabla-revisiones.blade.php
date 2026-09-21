<div class="overflow-x-auto w-full">
    <table class="w-full text-sm text-left text-gray-300">
        <thead class="text-xs uppercase bg-gray-800 text-gray-400 font-mono border-b border-gray-700">
            <tr>
                <th class="px-4 py-3">Fecha Resolución</th>
                <th class="px-4 py-3">Vehículo / Área</th>
                <th class="px-4 py-3">Reporte Original</th>
                <th class="px-4 py-3">Solución Aplicada</th>
                <th class="px-4 py-3 text-center">Estado</th>
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
                    <td class="px-4 py-3 text-xs text-emerald-300 max-w-xs truncate">{{ $row->solucion ?? 'Finalizado sin observaciones' }}</td>
                    <td class="px-4 py-3 text-center">
                        <span class="bg-emerald-950/60 border border-emerald-800 text-emerald-400 px-2.5 py-1 rounded-lg text-xs font-bold">
                            {{ $row->estado }}
                        </span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-circle-check text-2xl mb-2 block text-gray-600"></i>
                        No hay revisiones ni incidencias finalizadas registradas.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $datos->links() }}
</div>