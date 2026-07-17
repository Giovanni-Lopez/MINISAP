<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENOSA - Sucursales</title>
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
                        <i class="fa-solid fa-store text-red-500"></i> Control de Sucursales
                    </h2>
                    <button onclick="abrirModalRegistrar()" class="bg-red-600 hover:bg-red-700 transition text-white text-xs md:text-sm font-bold py-2 px-4 rounded-lg flex items-center gap-2 shadow-lg shadow-red-900/20 self-start sm:self-auto cursor-pointer">
                        <i class="fa-solid fa-plus"></i> Registrar Sucursal
                    </button>
                </div>

                @if(session('exito'))
                    <div class="bg-emerald-950 border border-emerald-500 text-emerald-300 p-4 rounded-lg text-sm flex items-center gap-2 mb-6">
                        <i class="fa-solid fa-circle-check text-emerald-500"></i> {{ session('exito') }}
                    </div>
                @endif

                <!-- Tabla de Sucursales -->
                <div class="grid grid-cols-1 gap-6 items-start">
                    <div class="bg-gray-800 p-5 rounded-xl border border-gray-700/50 shadow-md flex flex-col justify-between w-full">
                        <div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                                <h3 class="text-base font-bold text-white flex items-center gap-2">
                                    <i class="fa-solid fa-list-check text-gray-400"></i> Sucursales Operativas
                                </h3>
                                <div class="relative w-full sm:w-72">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fa-solid fa-magnifying-glass text-gray-500 text-sm"></i>
                                    </span>
                                    <input type="text" id="buscador" placeholder="Buscar sucursal o encargado..." class="w-full bg-gray-900 border border-gray-700 rounded-lg pl-9 pr-4 py-2 text-xs focus:outline-none focus:border-red-500 text-white placeholder-gray-500">
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm border-collapse table-fixed">
                                    <thead>
                                        <tr class="border-b border-gray-700 text-xs font-mono text-gray-400 uppercase">
                                            <th class="py-3 px-4 w-[20%]">Sucursal</th>
                                            <th class="py-3 px-4 w-[25%]">Jefe Sucursal / Contacto</th>
                                            <th class="py-3 px-4 w-[35%]">Dirección</th>
                                            <th class="py-3 px-4 text-left w-[20%]">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla-sucursales" class="divide-y divide-gray-700/50">
                                        <!-- Render JS -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Paginación -->
                        <div class="flex items-center justify-between border-t border-gray-700/50 pt-4 mt-4">
                            <span id="info-paginas" class="text-xs text-gray-400 font-mono">Mostrando 0 a 0 de 0 sucursales</span>
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

    <!-- MODAL: REGISTRAR SUCURSAL -->
    <div id="modal-registrar" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-sm px-4">
        <div class="bg-gray-900 border border-gray-800 w-full max-w-lg rounded-2xl p-6 shadow-2xl relative">
            <button onclick="cerrarModalRegistrar()" class="absolute top-4 right-4 text-gray-500 hover:text-white transition"><i class="fa-solid fa-xmark text-lg"></i></button>
            <h3 class="text-lg font-black text-white flex items-center gap-2 mb-4"><i class="fa-solid fa-store text-red-500"></i> Registrar Sucursal</h3>
            
            <form action="{{ route('sucursales.store') }}" method="POST">
                @csrf
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Seleccionar Sucursal *</label>
                        <select name="nombre_select" id="registrar-sucursal-select" onchange="evaluarSucursalManual(this.value, 'contenedor-otra-sucursal', 'otra_sucursal')" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                            <option value="Suc. San Salvador">Suc. San Salvador</option>
                            <option value="Suc. Ilopango">Suc. Ilopango</option>
                            <option value="Suc. Lourdes">Suc. Lourdes</option>
                            <option value="Suc. Santa Ana">Suc. Santa Ana</option>
                            <option value="OTRA">OTRA (Especificar...)</option>
                        </select>
                    </div>

                    <!-- Campo dinámico para nueva sucursal manual -->
                    <div id="contenedor-otra-sucursal" class="hidden mt-2">
                        <label class="block text-xs font-mono uppercase tracking-wider text-red-400 mb-1">Nombre de la Nueva Sucursal *</label>
                        <input type="text" id="otra_sucursal" name="otra_sucursal" placeholder="Ej: Suc. San Miguel" class="w-full bg-gray-800 border border-red-900/50 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                    </div>

                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Jefe de Sucursal *</label>
                        <input type="text" name="encargado" required placeholder="Nombre del responsable" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Teléfono de Contacto *</label>
                        <input type="text" name="telefono" id="tel-registrar" required placeholder="0000-0000" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500 font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Dirección Exacta *</label>
                        <textarea name="direccion" rows="2" required placeholder="Ubicación física de las instalaciones" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500"></textarea>
                    </div>
                </div>
                <div class="flex gap-2 pt-4 border-t border-gray-800 mt-4">
                    <button type="button" onclick="cerrarModalRegistrar()" class="w-1/2 bg-gray-800 hover:bg-gray-700 text-gray-300 py-2.5 rounded-xl text-sm">Cancelar</button>
                    <button type="submit" class="w-1/2 bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded-xl text-sm shadow-lg shadow-red-900/30">Guardar Sucursal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: EDITAR SUCURSAL -->
    <div id="modal-editar" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-sm px-4">
        <div class="bg-gray-900 border border-gray-800 w-full max-w-lg rounded-2xl p-6 shadow-2xl relative">
            <button onclick="cerrarModalEditar()" class="absolute top-4 right-4 text-gray-500 hover:text-white transition"><i class="fa-solid fa-xmark text-lg"></i></button>
            <h3 class="text-lg font-black text-white flex items-center gap-2 mb-4"><i class="fa-solid fa-pen-to-square text-blue-500"></i> Editar Sucursal</h3>
            
            <form id="form-editar" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Seleccionar Sucursal *</label>
                        <select name="nombre_select" id="edit-nombre" onchange="evaluarSucursalManual(this.value, 'contenedor-otra-sucursal-edit', 'edit-otra-sucursal-input')" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                            <option value="Suc. San Salvador">Suc. San Salvador</option>
                            <option value="Suc. Ilopango">Suc. Ilopango</option>
                            <option value="Suc. Lourdes">Suc. Lourdes</option>
                            <option value="Suc. Santa Ana">Suc. Santa Ana</option>
                            <option value="OTRA">OTRA (Especificar...)</option>
                        </select>
                    </div>
                    
                    <!-- Campo dinámico para nueva sucursal manual en edicion -->
                    <div id="contenedor-otra-sucursal-edit" class="hidden mt-2">
                        <label class="block text-xs font-mono uppercase tracking-wider text-blue-400 mb-1">Nombre de la Nueva Sucursal *</label>
                        <input type="text" id="edit-otra-sucursal-input" name="otra_sucursal" class="w-full bg-gray-800 border border-blue-900/50 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                    </div>

                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Jefe de Sucursal *</label>
                        <input type="text" name="encargado" id="edit-encargado" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Teléfono *</label>
                        <input type="text" name="telefono" id="tel-editar" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500 font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Dirección Exacta *</label>
                        <textarea name="direccion" id="edit-direccion" rows="2" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500"></textarea>
                    </div>
                </div>
                <div class="flex gap-2 pt-4 border-t border-gray-800 mt-4">
                    <button type="button" onclick="cerrarModalEditar()" class="w-1/2 bg-gray-800 hover:bg-gray-700 text-gray-300 py-2.5 rounded-xl text-sm">Cancelar</button>
                    <button type="submit" class="w-1/2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl text-sm shadow-lg shadow-blue-900/30">Actualizar Sucursal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const todasLasSucursales = @json($sucursales ?? []);
        let sucursalesFiltradas = [...todasLasSucursales];
        let paginaActual = 1;
        const limitePorPagina = 5;

        const buscador = document.getElementById('buscador');
        const tabla = document.getElementById('tabla-sucursales');
        const infoPaginas = document.getElementById('info-paginas');
        const btnPrev = document.getElementById('btn-prev');
        const btnNext = document.getElementById('btn-next');

        function abrirModalRegistrar() { document.getElementById('modal-registrar').classList.remove('hidden'); }
        function cerrarModalRegistrar() { 
            document.getElementById('modal-registrar').classList.add('hidden'); 
            document.getElementById('registrar-sucursal-select').value = 'Suc. San Salvador';
            document.getElementById('contenedor-otra-sucursal').classList.add('hidden');
            document.getElementById('otra_sucursal').required = false;
        }
        function cerrarModalEditar() { document.getElementById('modal-editar').classList.add('hidden'); }

        function evaluarSucursalManual(valor, idContenedor, idInput) {
            const contenedor = document.getElementById(idContenedor);
            const input = document.getElementById(idInput);
            
            if (valor === 'OTRA') {
                contenedor.classList.remove('hidden');
                input.required = true;
                input.focus();
            } else {
                contenedor.classList.add('hidden');
                input.required = false;
                input.value = '';
            }
        }

        function renderizarTabla() {
            const indexInicial = (paginaActual - 1) * limitePorPagina;
            const indexFinal = indexInicial + limitePorPagina;
            const itemsPagina = sucursalesFiltradas.slice(indexInicial, indexFinal);

            tabla.innerHTML = '';

            if (itemsPagina.length === 0) {
                tabla.innerHTML = `<tr><td colspan="4" class="text-center py-8 text-gray-500"><i class="fa-solid fa-store-slash text-2xl mb-2 block"></i>No hay sucursales registradas.</td></tr>`;
                infoPaginas.textContent = "Mostrando 0 de 0 resultados";
                btnPrev.disabled = true; btnNext.disabled = true;
                return;
            }

            itemsPagina.forEach(s => {
                const fila = document.createElement('tr');
                fila.className = "hover:bg-gray-900/50 transition border-b border-gray-800";
                fila.innerHTML = `
                    <td class="py-3 px-4 font-bold text-white flex items-center gap-2 mt-1">
                        <i class="fa-solid fa-location-dot text-red-500 text-xs"></i> ${s.nombre}
                    </td>
                    <td class="py-3 px-4">
                        <div class="text-xs font-medium text-gray-200">${s.encargado}</div>
                        <div class="text-[10px] font-mono text-gray-500"><i class="fa-solid fa-phone text-[9px]"></i> ${s.telefono}</div>
                    </td>
                    <td class="py-3 px-4 text-xs text-gray-400 truncate max-w-xs" title="${s.direccion}">
                        ${s.direccion}
                    </td>
                    <td class="py-3 px-4">
                        <div class="flex items-center justify-start gap-1.5">
                            <button onclick="abrirModalEditar(${s.id})" class="text-[11px] bg-blue-600/10 hover:bg-blue-600 text-blue-400 hover:text-white px-2.5 py-1 rounded-lg border border-blue-500/20 transition flex items-center gap-1 cursor-pointer">
                                <i class="fa-solid fa-pen text-[9px]"></i> Editar
                            </button>
                            <form action="/sucursales/${s.id}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar esta sucursal?');">
                                <input type="hidden" name="_token" value="${document.querySelector('input[name="_token"]').value}">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="text-[11px] bg-red-950/40 hover:bg-red-700 text-red-500 hover:text-white px-2.5 py-1 rounded-lg border border-red-900/30 transition flex items-center gap-1 cursor-pointer">
                                    <i class="fa-solid fa-trash text-[9px]"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                `;
                tabla.appendChild(fila);
            });

            const total = sucursalesFiltradas.length;
            infoPaginas.textContent = `Mostrando ${indexInicial + 1} a ${Math.min(indexFinal, total)} de ${total} sucursales`;
            btnPrev.disabled = paginaActual === 1;
            btnNext.disabled = indexFinal >= total;
        }

        function abrirModalEditar(id) {
            const s = todasLasSucursales.find(item => item.id === id);
            if (!s) return;
            
            document.getElementById('form-editar').action = `/sucursales/${id}`;
            document.getElementById('edit-encargado').value = s.encargado;
            document.getElementById('tel-editar').value = s.telefono; // <-- Aquí se corrigió el id a 'tel-editar'
            document.getElementById('edit-direccion').value = s.direccion;

            const selectNombre = document.getElementById('edit-nombre');
            const contenedorOtros = document.getElementById('contenedor-otra-sucursal-edit');
            const inputOtros = document.getElementById('edit-otra-sucursal-input');

            if (['Suc. San Salvador', 'Suc. Ilopango', 'Suc. Lourdes', 'Suc. Santa Ana'].includes(s.nombre)) {
                selectNombre.value = s.nombre;
                contenedorOtros.classList.add('hidden');
                inputOtros.required = false;
                inputOtros.value = '';
            } else {
                selectNombre.value = 'OTRA';
                contenedorOtros.classList.remove('hidden');
                inputOtros.required = true;
                inputOtros.value = s.nombre;
            }

            document.getElementById('modal-editar').classList.remove('hidden');
        }

        buscador.addEventListener('input', (e) => {
            const q = e.target.value.toLowerCase().trim();
            sucursalesFiltradas = todasLasSucursales.filter(s => s.nombre.toLowerCase().includes(q) || s.encargado.toLowerCase().includes(q));
            paginaActual = 1; renderizarTabla();
        });

        btnPrev.addEventListener('click', () => { if (paginaActual > 1) { paginaActual--; renderizarTabla(); } });
        btnNext.addEventListener('click', () => { if ((paginaActual * limitePorPagina) < sucursalesFiltradas.length) { paginaActual++; renderizarTabla(); } });

        function aplicarMascaraTelefono(el) {
            el.addEventListener('input', function (e) {
                let val = e.target.value.replace(/\D/g, '');
                if (val.length > 4) val = val.substring(0, 4) + '-' + val.substring(4, 8);
                e.target.value = val;
            });
        }
        aplicarMascaraTelefono(document.getElementById('tel-registrar'));
        aplicarMascaraTelefono(document.getElementById('tel-editar'));

        // Toggle Menú Móvil
        function toggleMenuMovil() {
            const sb = document.getElementById('sidebar-container');
            sb.classList.toggle('-translate-x-full');
        }

        renderizarTabla();
    </script>
</body>
</html>