<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENOSA - Muro de Lamentos Operativo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-900 text-gray-100 font-sans min-height-screen">

    <nav class="bg-gray-800 border-b border-red-600 px-6 py-4 shadow-xl flex justify-between items-center">
        <div class="flex items-center gap-3">
            <img src="https://lh3.googleusercontent.com/d/1AlBG27NmFnim8krD4_bb1aUWEdSLUlB3" alt="Logo RENOSA" class="h-12 w-auto object-contain">                        
        </div>
        <span class="text-sm bg-gray-700 px-3 py-1 rounded-full text-gray-300 font-mono">Muro de Lamentos v1.0</span>
    </nav>

    @include('ops.dashboard-kpis') 
     
    <div class="max-w-7xl mx-auto p-6 grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 shadow-lg h-fit">
            <h2 class="text-lg font-bold mb-4 flex items-center gap-2 text-white">
                <i class="fa-solid fa-pen-to-square text-red-500"></i> Registrar Nueva Incidencia
            </h2>
            <p class="text-xs text-gray-400 mb-6">Reporta problemas logísticos, fallas en sucursales o trabas operativas inmediatamente.</p>

            <form action="{{ route('incidencias.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase mb-2">Sucursal Afectada</label>
                    <select name="sucursal" required class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-gray-100 focus:outline-none focus:border-red-500 transition">
                        <option value="">Seleccione Sucursal...</option>
                        @foreach(array_keys($sucursalesConPlacas) as $sucursal)
                            <option value="{{ $sucursal }}">{{ $sucursal }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase mb-2">Placa del Vehículo</label>
                    <select name="placa" id="select-placa" disabled required class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-gray-100 focus:outline-none focus:border-red-500 transition disabled:opacity-40 disabled:cursor-not-allowed">
                        <option value="">Seleccione primero una sucursal...</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase mb-2">Nivel de Urgencia</label>
                    <select name="urgencia" required class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-gray-100 focus:outline-none focus:border-red-500 transition">
                        <option value="Baja">🟢 Baja (No interrumpe operación)</option>
                        <option value="Media" selected>🟡 Media (Afectación parcial)</option>
                        <option value="Alta">🟠 Alta (Retraso de despacho)</option>
                        <option value="Crítica">🔴 Crítica (Operación detenida)</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase mb-2">Descripción del "Lamento"</label>
                    <textarea name="descripcion" rows="4" required placeholder="Describe detalladamente el problema con la carga, equipo o retraso..." class="w-full bg-gray-900 border border-gray-700 rounded-lg px-4 py-2.5 text-gray-100 focus:outline-none focus:border-red-500 transition placeholder-gray-600 text-sm"></textarea>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-gray-400 uppercase mb-2">Evidencia Fotográfica (Opcional)</label>
                    <input type="file" name="imagen" accept="image/*" class="w-full text-xs text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-gray-700 file:text-white hover:file:bg-gray-600 cursor-pointer">
                </div>

                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-4 rounded-lg transition shadow-lg flex justify-center items-center gap-2">
                    <i class="fa-solid fa-bullhorn"></i> Publicar en el Muro
                </button>
            </form>
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
                        // Configuración dinámica de colores según urgencia
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
                                
                                {{-- Badge de la placa integrada en la cabecera de la tarjeta --}}
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