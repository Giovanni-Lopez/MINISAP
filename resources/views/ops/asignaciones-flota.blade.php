<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENOSA - Asignación de Flota</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-900 text-gray-100 font-sans h-screen flex flex-col overflow-hidden m-0 p-0 relative">
    
    <!-- Navbar Superior -->
    <nav class="bg-gray-800 border-b border-red-600 px-4 py-4 shadow-xl flex justify-between items-center h-16 w-full z-50 shrink-0">
        <div class="flex items-center gap-3">
            <button onclick="toggleMenuMovil()" class="md:hidden text-gray-400 hover:text-white text-xl p-1 focus:outline-none cursor-pointer">
                <i class="fa-solid fa-bars" id="icono-hamburguesa"></i>
            </button>
            <img src="https://lh3.googleusercontent.com/d/1AlBG27NmFnim8krD4_bb1aUWEdSLUlB3" alt="Logo RENOSA" class="h-10 w-auto object-contain">                        
        </div>
        <span class="text-xs md:text-sm bg-gray-700 px-3 py-1 rounded-full text-gray-300 font-mono">Muro de Lamentos v1.0</span>
    </nav>

    <div class="flex flex-1 w-full h-full overflow-hidden relative">

        <!-- Sidebar Lateral -->
        <div id="sidebar-container" class="fixed md:relative inset-y-0 left-0 top-16 md:top-0 z-40 w-64 bg-gray-900 border-r border-gray-800 transition-transform duration-300 ease-in-out transform -translate-x-full md:translate-x-0 h-[calc(100vh-4rem)] md:h-full flex flex-col shrink-0">
            @include('layouts.sidebar')
        </div>

        <div id="sidebar-overlay" onclick="toggleMenuMovil()" class="hidden fixed inset-0 bg-black/60 backdrop-blur-xs z-30 md:hidden"></div>

        <!-- Contenedor Principal -->
        <main class="flex-1 bg-gray-900 w-full h-full overflow-y-auto overflow-x-hidden pb-12">
            <div class="p-4 md:p-6 w-full max-w-[1600px] mx-auto">
                
                <!-- Encabezado -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <h2 class="text-xl md:text-2xl font-black text-white flex items-center gap-2">
                        <i class="fa-solid fa-key text-red-500"></i> Asignación de Flota
                    </h2>
                    <button onclick="abrirModalAsignar()" class="bg-red-600 hover:bg-red-700 transition text-white text-xs md:text-sm font-bold py-2 px-4 rounded-lg flex items-center gap-2 shadow-lg shadow-red-900/20 self-start sm:self-auto cursor-pointer">
                        <i class="fa-solid fa-plus"></i> Asignar Vehículo
                    </button>
                </div>

                @if(session('exito'))
                    <div class="bg-emerald-950 border border-emerald-500 text-emerald-300 p-4 rounded-lg text-sm flex items-center gap-2 mb-6">
                        <i class="fa-solid fa-circle-check text-emerald-500"></i> {{ session('exito') }}
                    </div>
                @endif

                <!-- Tabla de Asignaciones Activas -->
                <div class="grid grid-cols-1 gap-6 items-start">
                    <div class="bg-gray-800 p-5 rounded-xl border border-gray-700/50 shadow-md flex flex-col justify-between w-full">
                        <div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                                <h3 class="text-base font-bold text-white flex items-center gap-2">
                                    <i class="fa-solid fa-car-side text-gray-400"></i> Control de Custodia Activa
                                </h3>
                                <div class="relative w-full sm:w-72">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fa-solid fa-magnifying-glass text-gray-500 text-sm"></i>
                                    </span>
                                    <input type="text" id="buscador" placeholder="Buscar placa, conductor o marca..." class="w-full bg-gray-900 border border-gray-700 rounded-lg pl-9 pr-4 py-2 text-xs focus:outline-none focus:border-red-500 text-white placeholder-gray-500">
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm border-collapse table-fixed">
                                    <thead>
                                        <tr class="border-b border-gray-700 text-xs font-mono text-gray-400 uppercase">
                                            <th class="py-3 px-4 w-[25%]">Vehículo / Placa</th>
                                            <th class="py-3 px-4 w-[25%]">Conductor / Detalles</th>
                                            <th class="py-3 px-4 w-[15%] font-mono">F. Asignación</th>
                                            <th class="py-3 px-4 w-[20%]">Estado Inicial</th>
                                            <th class="py-3 px-4 text-left w-[15%]">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla-asignaciones" class="divide-y divide-gray-700/50">
                                        <!-- Render JS dinámico -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Paginación -->
                        <div class="flex items-center justify-between border-t border-gray-700/50 pt-4 mt-4">
                            <span id="info-paginas" class="text-xs text-gray-400 font-mono">Mostrando 0 a 0 de 0 asignaciones</span>
                            <div class="flex items-center gap-1">
                                <button id="btn-prev" class="px-3 py-1.5 bg-gray-900 border border-gray-700 text-gray-300 rounded hover:bg-gray-700 text-xs transition disabled:opacity-50">
                                    <i class="fa-solid fa-chevron-left"></i> Anterior
                                </button>
                                <button id="btn-next" class="px-3 py-1.5 bg-gray-900 border border-gray-700 text-gray-300 rounded hover:bg-gray-700 text-xs transition disabled:opacity-50">
                                    Siguiente <i class="fa-solid fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- MODAL: NUEVA ASIGNACIÓN -->
    <div id="modal-asignar" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-sm px-4">
        <div class="bg-gray-900 border border-gray-800 w-full max-w-lg rounded-2xl p-6 shadow-2xl relative">
            <button onclick="cerrarModalAsignar()" class="absolute top-4 right-4 text-gray-500 hover:text-white transition"><i class="fa-solid fa-xmark text-lg"></i></button>
            <h3 class="text-lg font-black text-white flex items-center gap-2 mb-4"><i class="fa-solid fa-id-card text-red-500"></i> Nueva Asignación de Flota</h3>
            
            <form action="{{ route('asignaciones.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Seleccionar Vehículo (Disponibles) *</label>
                        <select name="vehiculo_id" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                            <option value="" disabled selected>-- Elige un vehículo --</option>
                            @foreach($vehiculosDisponibles as $v)
                                <option value="{{ $v->id }}">{{ $v->placa }} - {{ $v->marca }} {{ $v->modelo }} ({{ $v->anio }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Asignar a Conductor *</label>
                        <select name="conductor_id" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                            <option value="" disabled selected>-- Selecciona al conductor --</option>
                            @foreach($conductores as $c)
                                <!-- Corrección aquí: cambiamos $c->nombre por nombres y apellidos -->
                                <option value="{{ $c->id }}">{{ $c->nombres }} {{ $c->apellidos }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Fecha de Entrega *</label>
                            <input type="date" name="fecha_asignacion" value="{{ date('Y-m-d') }}" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500 font-mono">
                        </div>
                        <div>
                            <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Estado Físico / Mecánico *</label>
                            <input type="text" name="estado_vehiculo" placeholder="Ej: Limpio, sin golpes" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Detalles u Observaciones</label>
                        <textarea name="observaciones" rows="2" placeholder="Ej: Se entrega con tarjeta de circulación original y kit de herramientas." class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500"></textarea>
                    </div>
                </div>

                <div class="flex gap-2 pt-4 border-t border-gray-800 mt-4">
                    <button type="button" onclick="cerrarModalAsignar()" class="w-1/2 bg-gray-800 hover:bg-gray-700 text-gray-300 py-2.5 rounded-xl text-sm">Cancelar</button>
                    <button type="submit" class="w-1/2 bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded-xl text-sm shadow-lg shadow-red-900/30">Confirmar Asignación</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Leemos las asignaciones activas enviadas desde el controlador
        const todasLasAsignaciones = @json($asignaciones ?? []);
        let asignacionesFiltradas = [...todasLasAsignaciones];
        let paginaActual = 1;
        const limitePorPagina = 5;

        const buscador = document.getElementById('buscador');
        const tabla = document.getElementById('tabla-asignaciones');
        const infoPaginas = document.getElementById('info-paginas');
        const btnPrev = document.getElementById('btn-prev');
        const btnNext = document.getElementById('btn-next');

        function abrirModalAsignar() { document.getElementById('modal-asignar').classList.remove('hidden'); }
        function cerrarModalAsignar() { document.getElementById('modal-asignar').classList.add('hidden'); }

        function renderizarTabla() {
            const indexInicial = (paginaActual - 1) * limitePorPagina;
            const indexFinal = indexInicial + limitePorPagina;
            const itemsPagina = asignacionesFiltradas.slice(indexInicial, indexFinal);

            tabla.innerHTML = '';

            if (itemsPagina.length === 0) {
                tabla.innerHTML = `<tr><td colspan="5" class="text-center py-8 text-gray-500"><i class="fa-solid fa-key text-2xl mb-2 block"></i>No hay vehículos asignados actualmente.</td></tr>`;
                infoPaginas.textContent = "Mostrando 0 de 0 resultados";
                btnPrev.disabled = true; btnNext.disabled = true;
                return;
            }

            itemsPagina.forEach(a => {
                const fila = document.createElement('tr');
                fila.className = "hover:bg-gray-900/50 transition border-b border-gray-800";
                
                // Formateo básico de fecha AAAA-MM-DD a DD/MM/AAAA
                const fechaArray = a.fecha_asignacion.split('-');
                const fechaFormateada = fechaArray.length === 3 ? `${fechaArray[2]}/${fechaArray[1]}/${fechaArray[0]}` : a.fecha_asignacion;

                // Validamos relaciones para evitar que rompa JS si un dato viene nulo
                const marca = a.vehiculo ? a.vehiculo.marca : 'N/A';
                const modelo = a.vehiculo ? a.vehiculo.modelo : '';
                const placa = a.vehiculo ? a.vehiculo.placa : 'S/P';
                
                // CORRECCIÓN: Concatenamos nombres y apellidos desde el objeto conductor
                const conductorNombre = a.conductor ? `${a.conductor.nombres} ${a.conductor.apellidos}` : 'Desconocido';

                fila.innerHTML = `
                    <td class="py-3 px-4 mt-1">
                        <div class="font-bold text-white flex items-center gap-1.5">
                            <i class="fa-solid fa-car text-red-500 text-xs"></i> ${marca} ${modelo}
                        </div>
                        <div class="text-[10px] font-mono bg-gray-900 border border-gray-700 rounded px-1.5 py-0.5 inline-block text-gray-400 mt-0.5">
                            ${placa}
                        </div>
                    </td>
                    <td class="py-3 px-4">
                        <div class="text-xs font-medium text-gray-200">${conductorNombre}</div>
                        <div class="text-[10px] font-mono text-gray-500">Conductor Asignado</div>
                    </td>
                    <td class="py-3 px-4 text-xs font-mono text-gray-400">
                        ${fechaFormateada}
                    </td>
                    <td class="py-3 px-4 text-xs text-gray-300 truncate max-w-xs" title="${a.observaciones || ''}">
                        <span class="text-xs font-semibold block text-amber-400">${a.estado_vehiculo}</span>
                        <span class="text-[11px] text-gray-500">${a.observaciones ? a.observaciones : 'Sin observaciones'}</span>
                    </td>
                    <td class="py-3 px-4">
                        <form action="/asignaciones-flota/liberar/${a.id}" method="POST" onsubmit="return confirm('¿Confirmas que el conductor ha devuelto el vehículo? El carro volverá a estar disponible.');">
                            <input type="hidden" name="_token" value="${document.querySelector('input[name="_token"]').value}">
                            <button type="submit" class="text-[11px] bg-emerald-950/40 hover:bg-emerald-700 text-emerald-400 hover:text-white px-2.5 py-1 rounded-lg border border-emerald-900/30 transition flex items-center gap-1 cursor-pointer font-bold">
                                <i class="fa-solid fa-box-open text-[9px]"></i> Liberar
                            </button>
                        </form>
                    </td>
                `;
                tabla.appendChild(fila);
            });

            const total = asignacionesFiltradas.length;
            infoPaginas.textContent = `Mostrando ${indexInicial + 1} a ${Math.min(indexFinal, total)} de ${total} asignaciones`;
            btnPrev.disabled = paginaActual === 1;
            btnNext.disabled = indexFinal >= total;
        }

        // Buscador reactivo en JS adaptado a Vehiculo y a Nombres/Apellidos del Conductor
        buscador.addEventListener('input', (e) => {
            const q = e.target.value.toLowerCase().trim();
            asignacionesFiltradas = todasLasAsignaciones.filter(a => {
                const placa = a.vehiculo?.placa?.toLowerCase() || '';
                const marca = a.vehiculo?.marca?.toLowerCase() || '';
                const modelo = a.vehiculo?.modelo?.toLowerCase() || '';
                
                // CORRECCIÓN: Buscador ahora concatena nombres y apellidos para validar coincidencias de texto
                const conductor = a.conductor ? `${a.conductor.nombres} ${a.conductor.apellidos}`.toLowerCase() : '';
                
                return placa.includes(q) || marca.includes(q) || modelo.includes(q) || conductor.includes(q);
            });
            paginaActual = 1; 
            renderizarTabla();
        });

        btnPrev.addEventListener('click', () => { if (paginaActual > 1) { paginaActual--; renderizarTabla(); } });
        btnNext.addEventListener('click', () => { if ((paginaActual * limitePorPagina) < asignacionesFiltradas.length) { paginaActual++; renderizarTabla(); } });

        function toggleMenuMovil() {
            const sb = document.getElementById('sidebar-container');
            sb.classList.toggle('-translate-x-full');
        }

        renderizarTabla();
    </script>
</body>
</html>