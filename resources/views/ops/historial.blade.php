@extends('layouts.app') {{-- O el layout principal que utilices en tu proyecto --}}

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    
    {{-- Tarjeta Principal --}}
    <div class="bg-gray-900 border border-gray-800 rounded-2xl shadow-xl p-6">
        
        {{-- Encabezado del Módulo --}}
        <div class="mb-6">
            <h2 class="text-2xl font-extrabold text-white flex items-center gap-2">
                <i class="fa-solid fa-clock-rotate-left text-red-500"></i> Centro de Historial y Auditoría
            </h2>
            <p class="text-xs text-gray-400 mt-1">Registros centralizados de la flota y operaciones.</p>
        </div>

        {{-- Barra de Pestañas / Navegación --}}
        <div class="flex flex-wrap gap-2 mb-6 pb-4 border-b border-gray-800">
            <a href="{{ route('incidencias.historial', ['tipo' => 'combustible']) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 {{ ($tipo ?? 'combustible') === 'combustible' ? 'bg-red-600 text-white shadow-lg shadow-red-900/30' : 'bg-gray-800 text-gray-400 hover:bg-gray-700 hover:text-white' }}">
                <i class="fa-solid fa-gas-pump"></i> Combustible
            </a>

            <a href="{{ route('incidencias.historial', ['tipo' => 'kilometraje']) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 {{ ($tipo ?? '') === 'kilometraje' ? 'bg-red-600 text-white shadow-lg shadow-red-900/30' : 'bg-gray-800 text-gray-400 hover:bg-gray-700 hover:text-white' }}">
                <i class="fa-solid fa-gauge-high"></i> KM Recorridos
            </a>

            <a href="{{ route('incidencias.historial', ['tipo' => 'revisiones']) }}" 
               class="px-4 py-2 rounded-xl text-xs font-bold transition flex items-center gap-2 {{ ($tipo ?? '') === 'revisiones' ? 'bg-red-600 text-white shadow-lg shadow-red-900/30' : 'bg-gray-800 text-gray-400 hover:bg-gray-700 hover:text-white' }}">
                <i class="fa-solid fa-circle-check"></i> Revisiones Finalizadas
            </a>
        </div>

        {{-- Contenido Dinámico según la Pestaña Seleccionada --}}
        <div>
            @if(($tipo ?? 'combustible') === 'combustible')
                @include('ops.historial_combustible', ['registros' => $datos])
            @elseif(($tipo ?? '') === 'kilometraje')
                @include('ops.partials.tabla-kilometraje', ['datos' => $datos])
            @elseif(($tipo ?? '') === 'revisiones')
                @include('ops.partials.tabla-revisiones', ['datos' => $datos])
            @else
                @include('ops.historial_combustible', ['registros' => $datos])
            @endif
        </div>

    </div>
</div>
@endsection