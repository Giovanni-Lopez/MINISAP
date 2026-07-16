<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENOSA - Muro de Lamentos Operativo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        /* Estilizar barra de scroll para el feed */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #111827; /* bg-gray-900 */
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #374151; /* bg-gray-700 */
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #00ff62a6; /* Verde/Rojo RENOSA para el hover */
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 font-sans h-screen flex flex-col overflow-hidden m-0 p-0 relative">
    
    <!-- Navbar -->
    <nav class="bg-gray-800 border-b border-red-600 px-4 py-4 shadow-xl flex justify-between items-center h-16 w-full z-50 shrink-0">
        <div class="flex items-center gap-3">
            <button id="btn-toggle-menu" class="text-gray-300 hover:text-white text-xl p-2 focus:outline-none md:hidden block cursor-pointer">
                <i class="fa-solid fa-bars"></i>
            </button>
            <img src="https://lh3.googleusercontent.com/d/1AlBG27NmFnim8krD4_bb1aUWEdSLUlB3" alt="Logo RENOSA" class="h-10 w-auto object-contain">                        
        </div>
        <span class="text-xs md:text-sm bg-gray-700 px-3 py-1 rounded-full text-gray-300 font-mono">Muro de Lamentos v1.0</span>
    </nav>

    <!-- Contenedor Base -->
    <div class="flex flex-1 w-full h-full overflow-hidden relative">

        <!-- Sidebar (Corregido: bg-gray-900 sólido para evitar transparencias y transform dinámico) -->
        <div id="sidebar-container" class="fixed md:relative inset-y-0 left-0 top-16 md:top-0 z-40 w-64 bg-gray-900 border-r border-gray-800 transition-transform duration-300 ease-in-out transform -translate-x-full md:translate-x-0 h-[calc(100vh-4rem)] md:h-full flex flex-col shrink-0">
            @include('layouts.sidebar')
        </div>

        <!-- Overlay de fondo para móviles -->
        <div id="sidebar-overlay" class="hidden fixed inset-0 bg-black/60 backdrop-blur-xs z-30 md:hidden"></div>

        <!-- Main Content -->
        <main class="flex-1 bg-gray-900 w-full h-full overflow-y-auto overflow-x-hidden pb-12 custom-scrollbar">
            <div class="p-4 md:p-6 w-full max-w-[1600px] mx-auto">
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- KPIs Dashboard -->
                    <div class="lg:col-span-3 w-full overflow-x-auto">
                        @include('ops.dashboard-kpis')
                    </div>
                     
                    <!-- Feed de Incidencias -->
                    <div class="lg:col-span-2 space-y-4">
                        <h2 class="text-base md:text-lg font-bold flex items-center gap-2 text-white mb-2">
                            <i class="fa-solid fa-list-timeline text-gray-400"></i> Feed Operativo Reciente
                        </h2>

                        @if(session('exito'))
                            <div class="bg-emerald-950 border border-emerald-500 text-emerald-300 p-4 rounded-lg text-sm flex items-center gap-2 mb-4 animate-bounce">
                                <i class="fa-solid fa-circle-check text-emerald-500"></i> {{ session('exito') }}
                            </div>
                        @endif

                        <!-- Contenedor del Feed con altura máxima fija y scroll interno -->
                        <div class="space-y-4 max-h-[calc(100vh-240px)] overflow-y-auto pr-2 custom-scrollbar">
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

                                    $estadoActual = $incidencia->estado ?? 'Pendiente';
                                    $estadoClass = 'bg-red-950 text-red-400 border border-red-800';
                                    if($estadoActual === 'En Revisión') {
                                        $estadoClass = 'bg-amber-950 text-amber-400 border border-amber-800';
                                    } elseif($estadoActual === 'Resuelto') {
                                        $estadoClass = 'bg-emerald-950 text-emerald-400 border border-emerald-800';
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
                                                    <span class="px-2.5 py-1 text-xs font-mono font-bold rounded bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                                        <i class="fa-solid fa-truck mr-1.5"></i> {{ $incidencia->placa }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <div class="flex flex-col sm:flex-row items-end sm:items-center gap-1.5 shrink-0">
                                            <span class="text-[10px] px-2 py-0.5 rounded font-bold uppercase {{ $badgeColor }}">{{ $incidencia->urgencia }}</span>
                                            
                                            <form action="{{ route('incidencias.update', $incidencia->id) }}" method="POST" class="inline">
                                                @csrf
                                                <select name="estado" onchange="this.form.submit()" class="text-[10px] px-2 py-0.5 rounded font-bold uppercase {{ $estadoClass }} bg-gray-950/80 cursor-pointer focus:outline-none focus:ring-1 focus:ring-red-500">
                                                    <option value="Pendiente" {{ $estadoActual == 'Pendiente' ? 'selected' : '' }}>🔴 Pendiente</option>
                                                    <option value="En Revisión" {{ $estadoActual == 'En Revisión' ? 'selected' : '' }}>🟡 En Proceso</option>
                                                    <option value="Resuelto" {{ $estadoActual == 'Resuelto' ? 'selected' : '' }}>🟢 Resuelto</option>
                                                </select>
                                            </form>
                                        </div>
                                    </div>

                                    <p class="text-sm text-gray-300 leading-relaxed bg-gray-900/40 p-3 rounded-lg border border-gray-700/50 break-words">
                                        {{ $incidencia->descripcion }}
                                    </p>

                                    @if(!empty($incidencia->comentarios))
                                        <div class="bg-emerald-950/20 border border-emerald-500/20 p-3 rounded-lg flex flex-col gap-1 mt-2">
                                            <span class="text-[9px] font-mono uppercase tracking-wider text-emerald-400 flex items-center gap-1.5">
                                                <i class="fa-solid fa-wrench text-[10px]"></i> Notas de Resolución / Bitácora:
                                            </span>
                                            <p class="text-xs text-gray-300 italic break-words">
                                                {{ $incidencia->comentarios }}
                                            </p>
                                        </div>
                                    @endif

                                    @if($incidencia->imagen_evidencia)
                                        <div class="w-full max-h-60 rounded-lg overflow-hidden border border-gray-700">
                                            <img src="{{ asset('storage/' . $incidencia->imagen_evidencia) }}" class="w-full h-full object-cover" alt="Evidencia">
                                        </div>
                                    @endif

                                    <div class="text-[11px] text-gray-500 flex justify-between items-center border-t border-gray-700/50 pt-3 font-mono">
                                        <span>ID: #00{{ $incidencia->id }} | <i class="fa-regular fa-clock mr-1"></i> {{ $incidencia->created_at->diffForHumans() }}</span>
                                        
                                        <button type="button" 
                                            onclick="abrirModalGestion({{ json_encode($incidencia) }})"
                                            class="px-3 py-1 bg-gray-900 border border-gray-700 hover:border-blue-500 hover:text-white text-gray-400 rounded-lg text-[10px] font-bold flex items-center gap-1 transition-all cursor-pointer">
                                            <i class="fa-solid fa-sliders text-[9px]"></i> Gestionar / Notas
                                        </button>
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

    <!-- MODAL DE GESTIÓN -->
    <div id="modalGestion" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-black/80 backdrop-blur-sm transition-opacity duration-300">
        <div class="bg-gray-900 border border-gray-800 rounded-2xl w-full max-w-lg p-6 shadow-2xl relative transform scale-95 transition-transform duration-300 mx-4">
            
            <div class="flex justify-between items-center pb-4 border-b border-gray-800">
                <div>
                    <h3 class="text-base font-black text-white tracking-tight flex items-center gap-2">
                        <span id="modalSucursal" class="text-red-500">Sucursal</span> 
                        <span id="modalPlaca" class="px-2 py-0.5 bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[10px] rounded font-mono">Placa</span>
                    </h3>
                    <p class="text-[11px] text-gray-500 mt-0.5" id="modalId">ID: #000</p>
                </div>
                <button onclick="cerrarModalGestion()" class="text-gray-400 hover:text-white transition-colors cursor-pointer">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form id="formActualizar" method="POST" action="" class="space-y-4 mt-4">
                @csrf
                
                <div class="bg-gray-950 p-4 rounded-xl border border-gray-800/50">
                    <span class="text-[9px] font-mono uppercase tracking-wider text-gray-500 block mb-1">Falla Reportada:</span>
                    <p id="modalDescripcion" class="text-sm text-gray-300 leading-relaxed italic">Sin descripción.</p>
                </div>

                <div>
                    <label class="block text-[10px] font-mono uppercase tracking-wider text-gray-400 mb-1.5">Cambiar Estado</label>
                    <select id="modalEstado" name="estado" class="w-full bg-gray-950 border border-gray-800 text-white rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all">
                        <option value="Pendiente">🔴 Pendiente</option>
                        <option value="En Revisión">🟡 En Proceso</option>
                        <option value="Resuelto">🟢 Resuelto</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-mono uppercase tracking-wider text-gray-400 mb-1.5">Notas de Resolución / Bitácora</label>
                    <textarea id="modalComentarios" name="comentarios" rows="3" placeholder="Ej. El mecánico ya revisó la unidad..." class="w-full bg-gray-950 border border-gray-800 text-white rounded-xl p-3 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition-all placeholder:text-gray-700 text-sm"></textarea>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="cerrarModalGestion()" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs font-bold rounded-xl transition-all cursor-pointer">
                        Cancelar
                    </button>
                    <button type="submit" class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition-all shadow-lg shadow-red-500/20 cursor-pointer">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- SCRIPTS DE CONTROL -->
    <script>
        // Lógica del Menú Desplegable Móvil (Corregida e Integrada)
        const btnToggleMenu = document.getElementById('btn-toggle-menu');
        const sidebar = document.getElementById('sidebar-container');
        const overlay = document.getElementById('sidebar-overlay');

        function toggleMenuMovil() {
            if (sidebar && overlay) {
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }
        }

        if (btnToggleMenu) {
            btnToggleMenu.addEventListener('click', function(e) {
                e.stopPropagation();
                toggleMenuMovil();
            });
        }

        if (overlay) {
            overlay.addEventListener('click', toggleMenuMovil);
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

        // Lógica del Modal
        function abrirModalGestion(incidencia) {
            const modal = document.getElementById('modalGestion');
            
            document.getElementById('modalSucursal').innerText = incidencia.sucursal || 'Sin Sucursal';
            document.getElementById('modalPlaca').innerText = incidencia.placa || 'S/P';
            document.getElementById('modalId').innerText = 'ID: #00' + incidencia.id;
            document.getElementById('modalDescripcion').innerText = incidencia.descripcion || 'Sin descripción';
            document.getElementById('modalEstado').value = incidencia.estado || 'Pendiente';
            document.getElementById('modalComentarios').value = incidencia.comentarios || '';

            document.getElementById('formActualizar').action = `/incidencias/${incidencia.id}/actualizar`;

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.firstElementChild.classList.remove('scale-95');
                modal.firstElementChild.classList.add('scale-100');
            }, 10);
        }

        function cerrarModalGestion() {
            const modal = document.getElementById('modalGestion');
            modal.firstElementChild.classList.remove('scale-100');
            modal.firstElementChild.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 200);
        }

        document.getElementById('modalGestion').addEventListener('click', function(e) {
            if (e.target === this) cerrarModalGestion();
        });
    </script>

</body>
</html>