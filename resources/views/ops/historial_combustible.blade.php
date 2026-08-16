@extends('layouts.app')

@section('titulo', 'Historial de Combustible')

@section('contenido')
<div class="w-full px-4 sm:px-6 py-6">
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-4 sm:p-6 shadow-2xl w-full">
        
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

                    <div class="grid grid-cols-2 gap-2 text-xs">
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
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center py-8 text-gray-500">
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
@endsection