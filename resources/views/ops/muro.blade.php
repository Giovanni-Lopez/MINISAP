<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENOSA - Muro de Lamentos Operativo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-900 text-gray-100 font-sans min-h-screen flex flex-col m-0 p-0 relative">
    
    <nav class="bg-gray-800 border-b border-red-600 px-4 py-4 shadow-xl flex justify-between items-center fixed top-0 w-full z-50 h-16">
        <div class="flex items-center gap-3">
            <button id="btn-toggle-menu" class="text-gray-300 hover:text-white text-xl p-2 focus:outline-none md:hidden block">
                <i class="fa-solid fa-bars"></i>
            </button>
            <img src="https://lh3.googleusercontent.com/d/1AlBG27NmFnim8krD4_bb1aUWEdSLUlB3" alt="Logo RENOSA" class="h-10 w-auto object-contain">                        
        </div>
        <span class="text-xs md:text-sm bg-gray-700 px-3 py-1 rounded-full text-gray-300 font-mono">Muro de Lamentos v1.0</span>
    </nav>

    <div id="mobile-menu" class="fixed inset-0 bg-gray-950/80 z-40 hidden transition-all duration-300 md:hidden">
        <div class="w-72 bg-gray-800 h-full p-5 pt-20 flex flex-col justify-between border-r border-gray-700 shadow-2xl">
            <div class="space-y-4">
                <h3 class="text-xs uppercase tracking-wider text-gray-500 font-mono font-bold px-2">Navegación</h3>
                <nav class="space-y-1">
                    <a href="/muro" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl bg-red-600 text-white">
                        <i class="fa-solid fa-clipboard-list w-5 text-center"></i> CheckList
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-gray-400 hover:bg-gray-700 hover:text-white">
                        <i class="fa-solid fa-network-wired w-5 text-center"></i> Sucursales
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-gray-400 hover:bg-gray-700 hover:text-white">
                        <i class="fa-solid fa-truck-moving w-5 text-center"></i> Flota / Placas
                    </a>
                    <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-gray-400 hover:bg-gray-700 hover:text-white">
                        <i class="fa-solid fa-clock-history w-5 text-center"></i> Historial
                    </a>
                </nav>
            </div>
            
            <div class="space-y-4">
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full text-gray-400 hover:text-white hover:bg-red-600/20 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-3 border border-transparent hover:border-red-500/20">
                        <i class="fa-solid fa-right-from-bracket text-red-500"></i> Cerrar Sesión
                    </button>
                </form>
                <div class="text-center text-[10px] text-gray-500 font-mono">RENOSA © 2026</div>
            </div>
        </div>
    </div>

    <div class="flex flex-1 w-full pt-16">

        @include('layouts.sidebar')

        <main class="flex-1 bg-gray-900 w-full overflow-x-hidden">
            <div class="p-4 md:p-6 w-full max-w-[1600px] mx-auto">
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <div class="lg:col-span-3 w-full overflow-x-auto">
                        @include('ops.dashboard-kpis')
                    </div>
                     
                    <div class="lg:col-span-2 space-y-4">
                        <h2 class="text-base md:text-lg font-bold flex items-center gap-2 text-white mb-2">
                            <i class="fa-solid fa-list-timeline text-gray-400"></i> Feed Operativo Reciente
                        </h2>

                        @if(session('exito'))
                            <div class="bg-emerald-950 border border-emerald-500 text-emerald-300 p-4 rounded-lg text-sm flex items-center gap-2 mb-4">
                                <i class="fa-solid fa-circle-check text-emerald-500"></i> {{ session('exito') }}
                            </div>
                        @endif

                        <div class="space-y-4">
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

                                <div class="bg-gray-800 p-4 md:p-5 rounded-xl border-l-8 {{ $borderColor }} shadow-md flex flex-col gap-4">
                                    <div class="flex justify-between items-start gap-2">
                                        <div class="flex items-center gap-3 flex-wrap">
                                            <div>
                                                <span class="text-[10px] uppercase font-mono tracking-wider text-gray-400 block">Sucursal</span>
                                                <h3 class="text-sm md:text-base font-bold text-white">
                                                    <i class="fa-solid fa-location-dot text-red-500 mr-1"></i> {{ $incidencia->sucursal }}
                                                </h3>
                                            </div>
                                            
                                            @if(!empty($incidencia->placa))
                                                <div class="pt-1">
                                                    <span class="px-2 py-0.5 text-[10px] font-mono font-bold rounded bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                                        <i class="fa-solid fa-truck mr-1"></i> {{ $incidencia->placa }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="flex flex-col sm:flex-row items-end sm:items-center gap-1.5 shrink-0">
                                            <span class="text-[10px] px-2 py-0.5 rounded font-bold uppercase {{ $badgeColor }}">{{ $incidencia->urgencia }}</span>
                                            <span class="text-[10px] px-2 py-0.5 rounded font-bold uppercase bg-gray-900 border border-gray-700 text-gray-400">{{ $incidencia->estado ?? 'Pendiente' }}</span>
                                        </div>
                                    </div>

                                    <p class="text-sm text-gray-300 leading-relaxed bg-gray-900/40 p-3 rounded-lg border border-gray-700/50 break-words">
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
                                <div class="bg-gray-800 p-8 md:p-12 rounded-xl text-center border border-gray-700 border-dashed text-gray-500">
                                    <i class="fa-solid fa-circle-nodes text-3xl mb-3 text-gray-600"></i>
                                    <p class="text-sm">No hay lamentos registrados hoy. Operación en orden.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </main>

    </div>

    <script>
        // Lógica del Menú Desplegable Móvil
        const btnToggleMenu = document.getElementById('btn-toggle-menu');
        const mobileMenu = document.getElementById('mobile-menu');

        if(btnToggleMenu && mobileMenu) {
            btnToggleMenu.addEventListener('click', function(e) {
                e.stopPropagation();
                mobileMenu.classList.toggle('hidden');
            });

            // Cerrar menú si se hace click fuera de él
            mobileMenu.addEventListener('click', function(e) {
                if(e.target === mobileMenu) {
                    mobileMenu.classList.add('hidden');
                }
            });
        }

        // Lógica de Sucursales y Placas Dinámicas
        const placasPorSucursal = @json($sucursalesConPlacas);
        const selectSucursal = document.querySelector('select[name="sucursal"]');
        const selectPlaca = document.getElementById('select-placa');

        if(selectSucursal && selectPlaca) {
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
        }
    </script>

</body>
</html>