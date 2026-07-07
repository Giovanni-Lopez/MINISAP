<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENOSA - Muro de Lamentos Operativo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-900 text-gray-100 font-sans min-h-screen flex flex-col m-0 p-0">
    <nav class="bg-gray-800 border-b border-red-600 px-6 py-4 shadow-xl flex justify-between items-center">
        <div class="flex items-center gap-3">
            <img src="https://lh3.googleusercontent.com/d/1AlBG27NmFnim8krD4_bb1aUWEdSLUlB3" alt="Logo RENOSA" class="h-12 w-auto object-contain">                        
        </div>
        <span class="text-sm bg-gray-700 px-3 py-1 rounded-full text-gray-300 font-mono">Muro de Lamentos v1.0</span>
    </nav>

    <div class="flex flex-1 w-full min-h-[calc(100vh-4rem)]">

        @include('layouts.sidebar')

        <main class="flex-1 bg-gray-900 overflow-y-auto">
            
            <div class="p-6 w-full max-w-[1600px] mx-auto">
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-3">
                        @include('ops.dashboard-kpis')
                    </div>
                     
                    

                    <div class="lg:col-span-2 space-y-4">
                        <h2 class="text-lg font-bold flex items-center gap-2 text-white mb-2">
                            <i class="fa-solid fa-list-timeline text-gray-400"></i> Feed Operativo Reciente
                        </h2>

                        @if(session('exito'))
                            <div class="bg-emerald-950 border border-emerald-500 text-emerald-300 p-4 rounded-lg text-sm flex items-center gap-2 mb-4">
                                <i class="fa-solid fa-circle-check text-emerald-500"></i> {{ session('exito') }}
                            </div>
                        @endif

                        <div class="space-y-4 overflow-y-auto max-h-[650px] pr-2">
                            @forelse($incidencias as $incidencia)
                                @php
                                    $borderColor = 'border-gray-700';
                                    $badgeColor = 'bg-gray-700 text-gray-300';
                                    $urgenciaLower = strtolower($incidencia->urgencia);

                                    if(in_array($urgenciaLower, ['alta', 'alto'])) { 
                                        $borderColor = 'border-orange-500'; 
                                        $badgeColor = 'bg-orange-950 text-orange-400 border border-orange-800'; 
                                    }
                                    if(in_array($urgenciaLower, ['crítica', 'critica', 'crítico', 'critico'])) { 
                                        $borderColor = 'border-red-500 animate-pulse'; 
                                        $badgeColor = 'bg-red-950 text-red-400 border border-red-800'; 
                                    }
                                    if(in_array($urgenciaLower, ['baja', 'bajo'])) { 
                                        $borderColor = 'border-emerald-700'; 
                                        $badgeColor = 'bg-emerald-950 text-emerald-400'; 
                                    }
                                @endphp

                                <div class="bg-gray-800 p-5 rounded-xl border-l-8 {{ $borderColor }} shadow-md flex flex-col gap-4">
                                    <div class="flex justify-between items-start">
                                        <div class="flex items-center gap-3 flex-wrap">
                                            <div>
                                                <span class="text-xs uppercase font-mono tracking-wider text-gray-400 block">Sucursal</span>
                                                <h3 class="text-base font-bold text-white">
                                                    <i class="fa-solid fa-location-dot text-red-500 mr-1"></i> {{ $incidencia->sucursal }}
                                                </h3>
                                            </div>
                                            
                                            @if(!empty($incidencia->placa))
                                                <div class="pt-4">
                                                    <span class="px-2 py-0.5 text-xs font-mono font-bold rounded bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                                        <i class="fa-solid fa-truck mr-1"></i> {{ $incidencia->placa }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs px-2.5 py-1 rounded font-bold uppercase {{ $badgeColor }}">{{ $incidencia->urgencia }}</span>
                                            <span class="text-xs px-2.5 py-1 rounded font-bold uppercase bg-gray-900 border border-gray-700 text-gray-400">{{ $incidencia->estado ?? 'Pendiente' }}</span>
                                        </div>
                                    </div>

                                    <p class="text-sm text-gray-300 leading-relaxed bg-gray-900/40 p-3 rounded-lg border border-gray-700/50">
                                        {{ $incidencia->descripcion }}
                                    </p>

                                    @if($incidencia->imagen_evidencia)
                                        <div class="w-full max-h-60 rounded-lg overflow-hidden border border-gray-700">
                                            <img src="{{ asset('storage/' . $incidencia->imagen_evidencia) }}" class="w-full h-full object-cover" alt="Evidencia">
                                        </div>
                                    @endif

                                    <div class="text-[11px] text-gray-500 flex justify-between items-center border-t border-gray-700/50 pt-3 font-mono">
                                        <span>ID: #00{{ $incidencia->id }}</span>
                                        <span><i class="fa-regular fa-clock mr-1"></i> {{ $incidencia->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="bg-gray-800 p-12 rounded-xl text-center border border-gray-700 border-dashed text-gray-500">
                                    <i class="fa-solid fa-circle-nodes text-4xl mb-3 text-gray-600"></i>
                                    <p class="text-sm">No hay lamentos registrados hoy en las sucursales. Operación en orden.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div> </div> </main>

    </div>

    <script>
        const placasPorSucursal = @json($sucursalesConPlacas);

        const selectSucursal = document.querySelector('select[name="sucursal"]');
        const selectPlaca = document.getElementById('select-placa');

        selectSucursal.addEventListener('change', function() {
            const sucursalSeleccionada = this.value;
            
            selectPlaca.innerHTML = '<option value="">Seleccione Placa...</option>';

            if (sucursalSeleccionada && placasPorSucursal[sucursalSeleccionada]) {
                selectPlaca.disabled = false;
                
                placasPorSucursal[sucursalSeleccionada].forEach(placa => {
                    const option = document.createElement('option');
                    option.value = placa;
                    option.textContent = placa;
                    selectPlaca.appendChild(option);
                });
            } else {
                selectPlaca.disabled = true;
                selectPlaca.innerHTML = '<option value="">Seleccione primero una sucursal...</option>';
            }
        });
    </script>

</body>
</html>