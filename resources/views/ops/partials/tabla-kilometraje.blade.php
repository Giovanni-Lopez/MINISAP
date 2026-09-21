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
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-800">
            @forelse($datos as $row)
                <tr class="hover:bg-gray-800/50 transition">
                    <td class="px-4 py-3 text-gray-400 font-mono text-xs">{{ $row->fecha ?? $row->created_at->format('Y-m-d') }}</td>
                    <td class="px-4 py-3 font-bold text-white">{{ $row->placa ?? $row->vehiculo->placa ?? 'N/D' }}</td>
                    <td class="px-4 py-3">{{ $row->motorista ?? $row->conductor->nombre ?? 'N/D' }}</td>
                    <td class="px-4 py-3 font-mono text-xs text-gray-400">{{ number_format($row->km_inicial ?? 0) }} km</td>
                    <td class="px-4 py-3 font-mono text-xs text-gray-400">{{ number_format($row->km_final ?? 0) }} km</td>
                    <td class="px-4 py-3 text-emerald-400 font-bold text-right font-mono">{{ number_format(($row->km_final ?? 0) - ($row->km_inicial ?? 0)) }} km</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-8 text-gray-500">
                        <i class="fa-solid fa-road text-2xl mb-2 block text-gray-600"></i>
                        No hay registros de kilometraje diario guardados aún.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-4">
    {{ $datos->links() }}
</div>