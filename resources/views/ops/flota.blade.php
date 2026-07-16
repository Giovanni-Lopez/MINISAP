<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENOSA - Gestión de Flota</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-900 text-gray-100 font-sans h-screen flex flex-col overflow-hidden m-0 p-0 relative">
    
    <!-- Navbar -->
    <nav class="bg-gray-800 border-b border-red-600 px-4 py-4 shadow-xl flex justify-between items-center h-16 w-full z-50 shrink-0">
        <div class="flex items-center gap-3">
            <img src="https://lh3.googleusercontent.com/d/1AlBG27NmFnim8krD4_bb1aUWEdSLUlB3" alt="Logo RENOSA" class="h-10 w-auto object-contain">                        
        </div>
        <span class="text-xs md:text-sm bg-gray-700 px-3 py-1 rounded-full text-gray-300 font-mono">Muro de Lamentos v1.0</span>
    </nav>

    <div class="flex flex-1 w-full h-full overflow-hidden">

        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Contenido Principal -->
        <main class="flex-1 bg-gray-900 w-full h-full overflow-y-auto overflow-x-hidden pb-12">
            <div class="p-4 md:p-6 w-full max-w-[1600px] mx-auto">
                
                <h2 class="text-xl md:text-2xl font-black text-white mb-6 flex items-center gap-2">
                    <i class="fa-solid fa-truck-moving text-red-500"></i> Control y Registro de Flotas
                </h2>

                @if(session('exito'))
                    <div class="bg-emerald-950 border border-emerald-500 text-emerald-300 p-4 rounded-lg text-sm flex items-center gap-2 mb-6">
                        <i class="fa-solid fa-circle-check text-emerald-500"></i> {{ session('exito') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    
                    <!-- Formulario para Registrar Nuevo Camión -->
                    <div class="bg-gray-800 p-5 rounded-xl border border-gray-700/50 shadow-md h-fit">
                        <h3 class="text-base font-bold text-white mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-plus-circle text-red-500"></i> Registrar Unidad
                        </h3>
                        
                        <form action="{{ route('flota.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Sucursal / Área</label>
                                <select name="sucursal" required class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500 text-white">
                                    <option value="">Selecciona Sucursal...</option>
                                    @foreach($sucursalesDisponibles as $sucursal)
                                        <option value="{{ $sucursal }}">{{ $sucursal }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Input de Placa -->
                            <div class="mb-4">
                                <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Número de Placa</label>
                                <input type="text" name="placa" value="{{ old('placa') }}" placeholder="Ej: M-966030" required 
                                    class="w-full bg-gray-800 border @error('placa') border-red-500 @else border-gray-700 @enderror rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner uppercase">
                                
                                <!-- MENSAJE DE ERROR DINÁMICO -->
                                @error('placa')
                                    <span class="text-xs text-red-500 font-semibold mt-1 block">
                                        <i class="fa-solid fa-triangle-exclamation mr-1"></i> {{ $message }}
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 transition text-white text-sm font-bold py-2.5 px-4 rounded-lg flex items-center justify-center gap-2">
                                <i class="fa-solid fa-save"></i> Guardar Unidad
                            </button>
                        </form>
                    </div>

                    <!-- Tabla / Listado de Unidades -->
                    <div class="lg:col-span-2 bg-gray-800 p-5 rounded-xl border border-gray-700/50 shadow-md flex flex-col justify-between">
                        <div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                                <h3 class="text-base font-bold text-white flex items-center gap-2">
                                    <i class="fa-solid fa-list-check text-gray-400"></i> Unidades Activas
                                </h3>
                                
                                <!-- Buscador moderno -->
                                <div class="relative w-full sm:w-72">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fa-solid fa-magnifying-glass text-gray-500 text-sm"></i>
                                    </span>
                                    <input type="text" id="buscador" placeholder="Buscar por placa o sucursal..." class="w-full bg-gray-900 border border-gray-700 rounded-lg pl-9 pr-4 py-2 text-xs focus:outline-none focus:border-red-500 text-white placeholder-gray-500">
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm border-collapse">
                                    <thead>
                                        <tr class="border-b border-gray-700 text-xs font-mono text-gray-400 uppercase">
                                            <th class="py-3 px-4">Sucursal</th>
                                            <th class="py-3 px-4">Placa / Identificador</th>
                                            <th class="py-3 px-4">Registrado El</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla-vehiculos" class="divide-y divide-gray-700/50">
                                        <!-- Se rellenará dinámicamente mediante JS -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Paginación de 10 en 10 -->
                        <div class="flex items-center justify-between border-t border-gray-700/50 pt-4 mt-4">
                            <span id="info-paginas" class="text-xs text-gray-400 font-mono">
                                Mostrando 0 a 0 de 0 unidades
                            </span>
                            <div class="flex items-center gap-1">
                                <button id="btn-prev" class="px-3 py-1.5 bg-gray-900 border border-gray-700 text-gray-300 rounded hover:bg-gray-700 text-xs transition disabled:opacity-50 disabled:pointer-events-none">
                                    <i class="fa-solid fa-chevron-left"></i> Anterior
                                </button>
                                <button id="btn-next" class="px-3 py-1.5 bg-gray-900 border border-gray-700 text-gray-300 rounded hover:bg-gray-700 text-xs transition disabled:opacity-50 disabled:pointer-events-none">
                                    Siguiente <i class="fa-solid fa-chevron-right"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>

    </div>

    <!-- Script de Búsqueda y Paginación Automática -->
    <script>
        // Pasamos todos los vehículos incluyendo la columna 'activo' e 'id'
        const todosLosVehiculos = @json($vehiculos);

        let vehiculosFiltrados = [...todosLosVehiculos];
        let paginaActual = 1;
        const limitePorPagina = 10;

        const buscador = document.getElementById('buscador');
        const tabla = document.getElementById('tabla-vehiculos');
        const infoPaginas = document.getElementById('info-paginas');
        const btnPrev = document.getElementById('btn-prev');
        const btnNext = document.getElementById('btn-next');

        function renderizarTabla() {
            const indexInicial = (paginaActual - 1) * limitePorPagina;
            const indexFinal = indexInicial + limitePorPagina;
            const itemsPagina = vehiculosFiltrados.slice(indexInicial, indexFinal);

            tabla.innerHTML = '';

            if (itemsPagina.length === 0) {
                tabla.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center py-8 text-gray-500">
                            <i class="fa-solid fa-circle-exclamation text-2xl mb-2 block"></i>
                            No se encontraron resultados.
                        </td>
                    </tr>`;
                infoPaginas.textContent = "Mostrando 0 de 0 resultados";
                btnPrev.disabled = true;
                btnNext.disabled = true;
                return;
            }

            itemsPagina.forEach(v => {
                const fila = document.createElement('tr');
                fila.className = `hover:bg-gray-900/50 transition ${!v.activo ? 'opacity-60 bg-gray-950/20' : ''}`;

                // Badge de Estado
                const badgeEstado = v.activo 
                    ? `<span class="px-2 py-0.5 text-[10px] font-bold rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20"><i class="fa-solid fa-circle text-[6px] mr-1 align-middle"></i> Activo</span>`
                    : `<span class="px-2 py-0.5 text-[10px] font-bold rounded bg-red-500/10 text-red-400 border border-red-500/20"><i class="fa-solid fa-circle text-[6px] mr-1 align-middle"></i> De Baja</span>`;

                // Botón de dar de baja / reactivar
                const btnAccion = v.activo
                    ? `<button type="submit" class="text-xs bg-red-600/10 hover:bg-red-600 text-red-400 hover:text-white px-3 py-1 rounded-lg border border-red-500/20 hover:border-red-600 transition flex items-center gap-1.5 ml-auto">
                        <i class="fa-solid fa-ban"></i> Dar de Baja
                    </button>`
                    : `<button type="submit" class="text-xs bg-emerald-600/10 hover:bg-emerald-600 text-emerald-400 hover:text-white px-3 py-1 rounded-lg border border-emerald-500/20 hover:border-emerald-600 transition flex items-center gap-1.5 ml-auto">
                        <i class="fa-solid fa-check"></i> Reactivar
                    </button>`;

                fila.innerHTML = `
                    <td class="py-3 px-4 font-bold text-white">
                        <i class="fa-solid fa-location-dot text-red-500 mr-1.5"></i> ${v.sucursal}
                    </td>
                    <td class="py-3 px-4">
                        <span class="px-2.5 py-1 text-xs font-mono font-bold rounded bg-amber-500/10 text-amber-400 border border-amber-500/20">
                            <i class="fa-solid fa-truck mr-1.5"></i> ${v.placa}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        ${badgeEstado}
                    </td>
                    <td class="py-3 px-4 text-right">
                        <form action="/flota/${v.id}/toggle-estado" method="POST">
                            <input type="hidden" name="_token" value="${document.querySelector('input[name="_token"]').value}">
                            <input type="hidden" name="_method" value="PATCH">
                            ${btnAccion}
                        </form>
                    </td>
                `;
                tabla.appendChild(fila);
            });

            const total = vehiculosFiltrados.length;
            const desde = indexInicial + 1;
            const hasta = Math.min(indexFinal, total);
            
            infoPaginas.textContent = `Mostrando ${desde} a ${hasta} de ${total} unidades`;

            btnPrev.disabled = paginaActual === 1;
            btnNext.disabled = indexFinal >= total;
        }

        // Escucha de Búsqueda
        buscador.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            
            vehiculosFiltrados = todosLosVehiculos.filter(v => {
                return v.sucursal.toLowerCase().includes(query) || v.placa.toLowerCase().includes(query);
            });

            paginaActual = 1;
            renderizarTabla();
        });

        // Eventos de botones
        btnPrev.addEventListener('click', () => {
            if (paginaActual > 1) {
                paginaActual--;
                renderizarTabla();
            }
        });

        btnNext.addEventListener('click', () => {
            if ((paginaActual * limitePorPagina) < vehiculosFiltrados.length) {
                paginaActual++;
                renderizarTabla();
            }
        });

        renderizarTabla();
    </script>

</body>
</html>