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

        <div id="sidebar-container" class="fixed md:relative inset-y-0 left-0 top-16 md:top-0 z-40 w-64 bg-gray-900 border-r border-gray-800 transition-transform duration-300 ease-in-out transform -translate-x-full md:translate-x-0 h-[calc(100vh-4rem)] md:h-full flex flex-col shrink-0">
            @include('layouts.sidebar')
        </div>

        <div id="sidebar-overlay" onclick="toggleMenuMovil()" class="hidden fixed inset-0 bg-black/60 backdrop-blur-xs z-30 md:hidden"></div>

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

                @if ($errors->any())
                    <div class="bg-red-950 border border-red-500 text-red-300 p-4 rounded-lg text-sm mb-6 flex flex-col gap-1">
                        <span class="font-bold text-red-400 flex items-center gap-2">
                            <i class="fa-solid fa-triangle-exclamation"></i> No se pudo guardar la unidad:
                        </span>
                        <ul class="list-disc pl-5 mt-1 space-y-1 text-xs">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 xl:grid-cols-3 gap-6 items-start">
                    
                    <div class="xl:col-span-1 bg-gray-800 p-5 rounded-xl border border-gray-700/50 shadow-md h-fit">
                        <h3 class="text-base font-bold text-white mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-plus-circle text-red-500"></i> Registrar Unidad
                        </h3>
                        
                        <form action="{{ route('flota.store') }}" method="POST" class="space-y-4">
                            @csrf
                            
                            <div class="grid grid-cols-2 gap-3">
                                
                                <div class="col-span-2">
                                    <label class="block text-[10px] font-mono uppercase tracking-wider text-gray-400 mb-1">Placa / Dominio *</label>
                                    <input type="text" name="placa" value="{{ old('placa') }}" placeholder="Ej: M-966030" required 
                                        class="w-full bg-gray-900 border @error('placa') border-red-500 @else border-gray-700 @enderror rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500 uppercase">
                                    @error('placa')
                                        <span class="text-[10px] text-red-500 mt-0.5 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-[10px] font-mono uppercase tracking-wider text-gray-400 mb-1">Año *</label>
                                    <input type="number" name="anio" min="1990" max="{{ date('Y')+1 }}" required placeholder="2024" class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-mono uppercase tracking-wider text-gray-400 mb-1">Marca *</label>
                                    <input type="text" name="marca" required placeholder="Toyota, Hino..." class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-mono uppercase tracking-wider text-gray-400 mb-1">Modelo *</label>
                                    <input type="text" name="modelo" required placeholder="Hilux, Dutro..." class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-mono uppercase tracking-wider text-gray-400 mb-1">Capacidad (Kg/L) *</label>
                                    <input type="text" name="capacidad" required placeholder="5 Ton, 1200 L..." class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-mono uppercase tracking-wider text-gray-400 mb-1">Tipo *</label>
                                    <input type="text" name="tipo" required placeholder="Camión, PickUp..." class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-mono uppercase tracking-wider text-gray-400 mb-1">Clase *</label>
                                    <input type="text" name="clase" required placeholder="Pesado, Liviano..." class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-mono uppercase tracking-wider text-gray-400 mb-1">En Calidad de *</label>
                                    <select name="en_calidad" required class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-sm focus:outline-none focus:border-red-500 text-white">
                                        <option value="Propietario">Propietario</option>
                                        <option value="A Plazos">A Plazos</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-mono uppercase tracking-wider text-gray-400 mb-1">Color *</label>
                                    <input type="text" name="color" required placeholder="Blanco, Rojo..." class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                                </div>

                                <div class="col-span-2">
                                    <label class="block text-[10px] font-mono uppercase tracking-wider text-gray-400 mb-1">N° Chasis *</label>
                                    <input type="text" name="n_chasis" required placeholder="Número de Chasis..." class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500 uppercase font-mono">
                                </div>

                                <div class="col-span-2">
                                    <label class="block text-[10px] font-mono uppercase tracking-wider text-gray-400 mb-1">N° Motor *</label>
                                    <input type="text" name="n_motor" required placeholder="Número de Motor..." class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500 uppercase font-mono">
                                </div>

                                <div class="col-span-2">
                                    <label class="block text-[10px] font-mono uppercase tracking-wider text-gray-400 mb-1">N° VIN *</label>
                                    <input type="text" name="n_vin" required placeholder="Número VIN..." class="w-full bg-gray-900 border border-gray-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500 uppercase font-mono">
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 transition text-white text-sm font-bold py-2.5 px-4 rounded-lg flex items-center justify-center gap-2 mt-2">
                                <i class="fa-solid fa-save"></i> Guardar Unidad
                            </button>
                        </form>
                    </div>

                    <div class="xl:col-span-2 bg-gray-800 p-5 rounded-xl border border-gray-700/50 shadow-md flex flex-col justify-between">
                        <div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                                <h3 class="text-base font-bold text-white flex items-center gap-2">
                                    <i class="fa-solid fa-list-check text-gray-400"></i> Inventario de Flota Activa
                                </h3>
                                
                                <div class="relative w-full sm:w-72">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fa-solid fa-magnifying-glass text-gray-500 text-sm"></i>
                                    </span>
                                    <input type="text" id="buscador" placeholder="Buscar por placa, marca, chasis..." class="w-full bg-gray-900 border border-gray-700 rounded-lg pl-9 pr-4 py-2 text-xs focus:outline-none focus:border-red-500 text-white placeholder-gray-500">
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm border-collapse">
                                    <thead>
                                        <tr class="border-b border-gray-700 text-xs font-mono text-gray-400 uppercase">
                                            <th class="py-3 px-4">Placa</th>
                                            <th class="py-3 px-4">Ficha Técnica</th>
                                            <th class="py-3 px-4">Números de Serie</th>
                                            <th class="py-3 px-4">Estado</th>
                                            <th class="py-3 px-4 text-right">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla-vehiculos" class="divide-y divide-gray-700/50">
                                        </tbody>
                                </table>
                            </div>
                        </div>

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

    <div id="modal-editar" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-sm px-4 overflow-y-auto">
        <div class="bg-gray-900 border border-gray-800 w-full max-w-xl rounded-2xl p-6 shadow-2xl relative my-8">
            
            <button onclick="cerrarModalEditar()" class="absolute top-4 right-4 text-gray-500 hover:text-white transition cursor-pointer">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>

            <h3 class="text-lg font-black text-white flex items-center gap-2 mb-4">
                <i class="fa-solid fa-pen-to-square text-red-500"></i> Editar Ficha de Unidad
            </h3>

            <form id="form-editar-vehiculo" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-2 gap-3 max-h-[60vh] overflow-y-auto pr-1 custom-scrollbar">
                    <div class="col-span-2">
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Número de Placa *</label>
                        <input type="text" name="placa" id="modal-placa-input" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500 uppercase">
                    </div>

                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Año</label>
                        <input type="number" name="anio" id="modal-anio-input" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Marca</label>
                        <input type="text" name="marca" id="modal-marca-input" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Modelo</label>
                        <input type="text" name="modelo" id="modal-modelo-input" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Capacidad</label>
                        <input type="text" name="capacidad" id="modal-capacidad-input" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Tipo</label>
                        <input type="text" name="tipo" id="modal-tipo-input" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Clase</label>
                        <input type="text" name="clase" id="modal-clase-input" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">En Calidad de</label>
                        <select name="en_calidad" id="modal-calidad-select" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                            <option value="Propietario">Propietario</option>
                            <option value="A Plazos">A Plazos</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Color</label>
                        <input type="text" name="color" id="modal-color-input" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">N° Chasis</label>
                        <input type="text" name="n_chasis" id="modal-chasis-input" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500 uppercase font-mono">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">N° Motor</label>
                        <input type="text" name="n_motor" id="modal-motor-input" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500 uppercase font-mono">
                    </div>
                    <div class="col-span-2">
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">N° VIN</label>
                        <input type="text" name="n_vin" id="modal-vin-input" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500 uppercase font-mono">
                    </div>
                </div>

                <div class="flex gap-2 pt-4 border-t border-gray-800 mt-4">
                    <button type="button" onclick="cerrarModalEditar()" class="w-1/2 bg-gray-800 hover:bg-gray-700 text-gray-300 font-semibold py-2.5 rounded-xl transition text-sm">
                        Cancelar
                    </button>
                    <button type="submit" class="w-1/2 bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded-xl transition flex items-center justify-center gap-2 text-sm shadow-lg shadow-red-900/30">
                        <i class="fa-solid fa-floppy-disk"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
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
                        <td colspan="5" class="text-center py-8 text-gray-500">
                            <i class="fa-solid fa-circle-exclamation text-2xl mb-2 block"></i>
                            No se encontraron unidades registradas.
                        </td>
                    </tr>`;
                infoPaginas.textContent = "Mostrando 0 de 0 resultados";
                btnPrev.disabled = true;
                btnNext.disabled = true;
                return;
            }

            itemsPagina.forEach(v => {
                const fila = document.createElement('tr');
                fila.className = `hover:bg-gray-900/50 transition border-b border-gray-800 ${!v.activo ? 'opacity-60 bg-gray-950/20' : ''}`;

                const badgeEstado = v.activo 
                    ? `<span class="px-2 py-0.5 text-[10px] font-bold rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20"><i class="fa-solid fa-circle text-[6px] mr-1 align-middle"></i> Activo</span>`
                    : `<span class="px-2 py-0.5 text-[10px] font-bold rounded bg-red-500/10 text-red-400 border border-red-500/20"><i class="fa-solid fa-circle text-[6px] mr-1 align-middle"></i> De Baja</span>`;

                const btnAccion = v.activo
                    ? `<button type="submit" class="text-[11px] bg-red-600/10 hover:bg-red-600 text-red-400 hover:text-white px-2.5 py-1 rounded-lg border border-red-500/20 transition flex items-center gap-1 cursor-pointer">
                        <i class="fa-solid fa-ban text-[9px]"></i> Baja
                    </button>`
                    : `<button type="submit" class="text-[11px] bg-emerald-600/10 hover:bg-emerald-600 text-emerald-400 hover:text-white px-2.5 py-1 rounded-lg border border-emerald-500/20 transition flex items-center gap-1 cursor-pointer">
                        <i class="fa-solid fa-check text-[9px]"></i> Alta
                    </button>`;

                const vehiculoJson = JSON.stringify(v).replace(/'/g, "\\'");

                const btnEditar = `<button type="button" onclick='abrirModalEditar(${vehiculoJson})' class="text-[11px] bg-blue-600/10 hover:bg-blue-600 text-blue-400 hover:text-white px-2.5 py-1 rounded-lg border border-blue-500/20 transition flex items-center gap-1 cursor-pointer">
                    <i class="fa-solid fa-pen-to-square text-[9px]"></i> Editar
                </button>`;

                // Columna 2: Ficha Técnica Simplificada
                const detallesFicha = `
                    <div class="text-[11px] space-y-0.5 py-1">
                        <span class="text-gray-300 font-semibold">${v.marca || ''} ${v.modelo || ''} (${v.anio || ''})</span>
                        <div class="text-gray-500 font-mono text-[10px] flex gap-2 flex-wrap">
                            <span>Tipo: ${v.tipo || 'S/T'}</span> | 
                            <span>Clase: ${v.clase || 'S/C'}</span> | 
                            <span>Calidad: ${v.en_calidad || 'Propio'}</span>
                        </div>
                    </div>
                `;

                // Columna 3: Números de Serie e Identificadores Técnicos
                const seriesFicha = `
                    <div class="text-[10px] font-mono text-gray-400 space-y-0.5">
                        <div><span class="text-gray-500">Chasis:</span> ${v.n_chasis || 'S/N'}</div>
                        <div><span class="text-gray-500">Motor:</span> ${v.n_motor || 'S/N'}</div>
                        <div><span class="text-gray-500">VIN:</span> ${v.n_vin || 'S/N'}</div>
                    </div>
                `;

                fila.innerHTML = `
                    <td class="py-3 px-4">
                        <span class="px-2.5 py-1 text-xs font-mono font-bold rounded bg-amber-500/10 text-amber-400 border border-amber-500/20">
                            <i class="fa-solid fa-truck mr-1.5"></i> ${v.placa}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        ${detallesFicha}
                    </td>
                    <td class="py-3 px-4">
                        ${seriesFicha}
                    </td>
                    <td class="py-3 px-4">
                        ${badgeEstado}
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex items-center justify-end gap-2">
                            ${btnEditar}
                            <form action="/flota/${v.id}/toggle-estado" method="POST">
                                <input type="hidden" name="_token" value="${document.querySelector('input[name="_token"]').value}">
                                <input type="hidden" name="_method" value="PATCH">
                                ${btnAccion}
                            </form>
                        </div>
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

        function abrirModalEditar(v) {
            const form = document.getElementById('form-editar-vehiculo');
            form.action = `/flota/update/${v.id}`;

            document.getElementById('modal-placa-input').value = v.placa || '';
            document.getElementById('modal-anio-input').value = v.anio || '';
            document.getElementById('modal-marca-input').value = v.marca || '';
            document.getElementById('modal-modelo-input').value = v.modelo || '';
            document.getElementById('modal-capacidad-input').value = v.capacidad || '';
            document.getElementById('modal-tipo-input').value = v.tipo || '';
            document.getElementById('modal-clase-input').value = v.clase || '';
            document.getElementById('modal-calidad-select').value = v.en_calidad || 'Propiedad';
            document.getElementById('modal-color-input').value = v.color || '';
            document.getElementById('modal-chasis-input').value = v.n_chasis || '';
            document.getElementById('modal-motor-input').value = v.n_motor || '';
            document.getElementById('modal-vin-input').value = v.n_vin || '';

            document.getElementById('modal-editar').classList.remove('hidden');
        }

        function cerrarModalEditar() {
            document.getElementById('modal-editar').classList.add('hidden');
        }

        // Buscador Inteligente multi-criterio técnico
        buscador.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            
            vehiculosFiltrados = todosLosVehiculos.filter(v => {
                return v.placa.toLowerCase().includes(query) ||
                       (v.marca && v.marca.toLowerCase().includes(query)) ||
                       (v.modelo && v.modelo.toLowerCase().includes(query)) ||
                       (v.n_chasis && v.n_chasis.toLowerCase().includes(query)) ||
                       (v.n_motor && v.n_motor.toLowerCase().includes(query));
            });

            paginaActual = 1;
            renderizarTabla();
        });

        btnPrev.addEventListener('click', () => {
            if (paginaActual > 1) { paginaActual--; renderizarTabla(); }
        });

        btnNext.addEventListener('click', () => {
            if ((paginaActual * limitePorPagina) < vehiculosFiltrados.length) { paginaActual++; renderizarTabla(); }
        });

        function toggleMenuMovil() {
            const sidebar = document.getElementById('sidebar-container');
            const overlay = document.getElementById('sidebar-overlay');
            const icono = document.getElementById('icono-hamburguesa');

            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
                icono.classList.remove('fa-bars');
                icono.classList.add('fa-xmark');
            } else {
                sidebar.classList.remove('translate-x-0');
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
                icono.classList.remove('fa-xmark');
                icono.classList.add('fa-bars');
            }
        }

        renderizarTabla();
    </script>
</body>
</html>