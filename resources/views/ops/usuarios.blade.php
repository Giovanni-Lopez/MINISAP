<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENOSA - Control de Usuarios y Licencias</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
                        <i class="fa-solid fa-users-gear text-red-500"></i> Control de Conductores y Licencias
                    </h2>
                    <button onclick="abrirModalRegistrar()" class="bg-red-600 hover:bg-red-700 transition text-white text-xs md:text-sm font-bold py-2 px-4 rounded-lg flex items-center gap-2 shadow-lg shadow-red-900/20 self-start sm:self-auto cursor-pointer">
                        <i class="fa-solid fa-user-plus"></i> Registrar Conductor / Licencia
                    </button>
                </div>

                @if(session('exito'))
                    <div class="bg-emerald-950 border border-emerald-500 text-emerald-300 p-4 rounded-lg text-sm flex items-center gap-2 mb-6">
                        <i class="fa-solid fa-circle-check text-emerald-500"></i> {{ session('exito') }}
                    </div>
                @endif

                <!-- Tabla de Personal -->
                <div class="grid grid-cols-1 gap-6 items-start">
                    <div class="bg-gray-800 p-5 rounded-xl border border-gray-700/50 shadow-md flex flex-col justify-between w-full">
                        <div>
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                                <h3 class="text-base font-bold text-white flex items-center gap-2">
                                    <i class="fa-solid fa-address-book text-gray-400"></i> Personal y Licencias Asignadas
                                </h3>
                                <div class="relative w-full sm:w-72">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fa-solid fa-magnifying-glass text-gray-500 text-sm"></i>
                                    </span>
                                    <input type="text" id="buscador" placeholder="Buscar por conductor, DUI o clase..." class="w-full bg-gray-900 border border-gray-700 rounded-lg pl-9 pr-4 py-2 text-xs focus:outline-none focus:border-red-500 text-white placeholder-gray-500">
                                </div>
                            </div>

                            <!-- Contenedor con scroll horizontal en móviles -->
                            <div class="overflow-x-auto w-full">
                                <table class="w-full text-left text-sm border-collapse min-w-[700px]">
                                    <thead>
                                        <tr class="border-b border-gray-700 text-xs font-mono text-gray-400 uppercase">
                                            <th class="py-3 px-4 w-1/4">Nombre Completo</th>
                                            <th class="py-3 px-4 w-1/6">DUI</th>
                                            <th class="py-3 px-4 w-5/12">Licencias Registradas</th>
                                            <th class="py-3 px-4 text-left w-1/6">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla-usuarios" class="divide-y divide-gray-700/50">
                                        <!-- Renderizado dinámico JS -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Paginación -->
                        <div class="flex items-center justify-between border-t border-gray-700/50 pt-4 mt-4">
                            <span id="info-paginas" class="text-xs text-gray-400 font-mono">Mostrando 0 a 0 de 0 conductores</span>
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

    <!-- MODAL: REGISTRAR CONDUCTOR O ADICIONAR LICENCIA -->
    <div id="modal-registrar" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-sm px-4 overflow-y-auto">
        <div class="bg-gray-900 border border-gray-800 w-full max-w-xl rounded-2xl p-6 shadow-2xl relative my-8">
            
            <button onclick="cerrarModalRegistrar()" class="absolute top-4 right-4 text-gray-500 hover:text-white transition cursor-pointer">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>

            <h3 id="modal-titulo" class="text-lg font-black text-white flex items-center gap-2 mb-4">
                <i class="fa-solid fa-user-plus text-red-500"></i> Registrar Licencia
            </h3>

            <form id="form-conductor" action="{{ route('conductores.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-3 max-h-[65vh] overflow-y-auto pr-1">
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Nombres *</label>
                        <input type="text" name="nombres" id="reg-nombres" required placeholder="Ej: Juan Antonio" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Apellidos *</label>
                        <input type="text" name="apellidos" id="reg-apellidos" required placeholder="Ej: Pérez Quintanilla" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">DUI *</label>
                        <input type="text" name="dui" id="input-dui" required placeholder="00000000-0" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500 font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">No. Licencia</label>
                        <input type="text" name="no_licencia" id="reg-no-licencia" placeholder="0000-000000-000-0" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500 font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Clase de Licencia *</label>
                        <select name="clase_select" id="clase_select" onchange="evaluarClaseLicencia(this.value)" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                            <option value="D LIVIANA">LIVIANA</option>
                            <option value="C PESADA">PESADA</option>
                            <option value="A MOTOCICLETA">MOTOCICLETA</option>
                            <option value="OTROS">OTROS (Especificar)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Fecha Vencimiento *</label>
                        <input type="date" name="vence" id="reg-vence" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500 font-mono">
                    </div>

                    <!-- CAMPO DINÁMICO PARA "OTROS" -->
                    <div id="contenedor-otra-clase" class="col-span-2 hidden">
                        <label class="block text-xs font-mono uppercase tracking-wider text-red-400 mb-1">Escriba la otra clase de licencia *</label>
                        <input type="text" name="otra_clase" id="otra_clase" placeholder="Ej: ESPECIAL" class="w-full bg-gray-800 border border-red-900/50 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500 uppercase">
                    </div>
                </div>

                <div class="flex gap-2 pt-4 border-t border-gray-800 mt-4">
                    <button type="button" onclick="cerrarModalRegistrar()" class="w-1/2 bg-gray-800 hover:bg-gray-700 text-gray-300 font-semibold py-2.5 rounded-xl transition text-sm">
                        Cancelar
                    </button>
                    <button type="submit" class="w-1/2 bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded-xl transition flex items-center justify-center gap-2 text-sm shadow-lg shadow-red-900/30">
                        <i class="fa-solid fa-save"></i> Guardar Licencia
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: EDITAR DATOS CONDUCTOR -->
    <div id="modal-editar" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-sm px-4 overflow-y-auto">
        <div class="bg-gray-900 border border-gray-800 w-full max-w-md rounded-2xl p-6 shadow-2xl relative my-8">
            
            <button type="button" onclick="cerrarModalEditar()" class="absolute top-4 right-4 text-gray-500 hover:text-white transition cursor-pointer">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>

            <h3 class="text-lg font-black text-white flex items-center gap-2 mb-4">
                <i class="fa-solid fa-user-pen text-blue-500"></i> Editar Datos de Conductor
            </h3>

            <form id="form-editar" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Nombres *</label>
                        <input type="text" name="nombres" id="edit-nombres" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Apellidos *</label>
                        <input type="text" name="apellidos" id="edit-apellidos" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">DUI *</label>
                        <input type="text" name="dui" id="edit-dui" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500 font-mono">
                    </div>
                </div>

                <div class="flex gap-2 pt-4 border-t border-gray-800 mt-4">
                    <button type="button" onclick="cerrarModalEditar()" class="w-1/2 bg-gray-800 hover:bg-gray-700 text-gray-300 font-semibold py-2.5 rounded-xl transition text-sm">
                        Cancelar
                    </button>
                    <button type="submit" class="w-1/2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl transition flex items-center justify-center gap-2 text-sm shadow-lg shadow-blue-900/30">
                        <i class="fa-solid fa-save"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- FORMS OCULTOS PARA ELIMINACIÓN -->
    <form id="form-eliminar-licencia" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <form id="form-eliminar-conductor" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <script>
        const todosLosUsuarios = @json($usuarios ?? []);

        let usuariosFiltrados = [...todosLosUsuarios];
        let paginaActual = 1;
        const limitePorPagina = 5;

        const buscador = document.getElementById('buscador');
        const tabla = document.getElementById('tabla-usuarios');
        const infoPaginas = document.getElementById('info-paginas');
        const btnPrev = document.getElementById('btn-prev');
        const btnNext = document.getElementById('btn-next');

        function abrirModalRegistrar() {
            document.getElementById('modal-titulo').innerHTML = `<i class="fa-solid fa-user-plus text-red-500"></i> Registrar Nuevo Conductor`;
            document.getElementById('form-conductor').reset();
            document.getElementById('input-dui').readOnly = false;
            evaluarClaseLicencia(document.getElementById('clase_select').value);
            document.getElementById('modal-registrar').classList.remove('hidden');
        }

        function abrirModalAgregarLicencia(conductor) {
            document.getElementById('modal-titulo').innerHTML = `<i class="fa-solid fa-id-card text-red-500"></i> Agregar Licencia a ${conductor.nombres}`;
            document.getElementById('form-conductor').reset();
            
            document.getElementById('reg-nombres').value = conductor.nombres;
            document.getElementById('reg-apellidos').value = conductor.apellidos;
            document.getElementById('input-dui').value = conductor.dui;
            document.getElementById('input-dui').readOnly = true;

            evaluarClaseLicencia(document.getElementById('clase_select').value);
            document.getElementById('modal-registrar').classList.remove('hidden');
        }

        function cerrarModalRegistrar() {
            document.getElementById('modal-registrar').classList.add('hidden');
        }

        function evaluarClaseLicencia(valor) {
            const contenedor = document.getElementById('contenedor-otra-clase');
            const inputOtraClase = document.getElementById('otra_clase');
            
            if (valor === 'OTROS') {
                contenedor.classList.remove('hidden');
                inputOtraClase.required = true;
                inputOtraClase.focus();
            } else {
                contenedor.classList.add('hidden');
                inputOtraClase.required = false;
                inputOtraClase.value = '';
            }
        }

        function renderizarTabla() {
            const indexInicial = (paginaActual - 1) * limitePorPagina;
            const indexFinal = indexInicial + limitePorPagina;
            const itemsPagina = usuariosFiltrados.slice(indexInicial, indexFinal);

            tabla.innerHTML = '';

            if (itemsPagina.length === 0) {
                tabla.innerHTML = `
                    <tr>
                        <td colspan="4" class="text-center py-8 text-gray-500">
                            <i class="fa-solid fa-user-slash text-2xl mb-2 block"></i>
                            No se encontraron conductores registrados.
                        </td>
                    </tr>`;
                infoPaginas.textContent = "Mostrando 0 de 0 resultados";
                btnPrev.disabled = true;
                btnNext.disabled = true;
                return;
            }

            itemsPagina.forEach(u => {
                const fila = document.createElement('tr');
                fila.className = "hover:bg-gray-900/50 transition border-b border-gray-800";

                let htmlLicencias = '<span class="text-xs text-gray-500 italic">Sin licencias asignadas</span>';
                
                if (u.licencias && u.licencias.length > 0) {
                    htmlLicencias = u.licencias.map(lic => {
                        const fechaVenc = lic.vence ? lic.vence.split('T')[0] : 'S/V';
                        const hoy = new Date().toISOString().split('T')[0];
                        const estaVencida = lic.vence && fechaVenc < hoy;

                        // Badge dinámico para estado VIGENTE / VENCIDA
                        const badgeEstado = estaVencida 
                            ? `<span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-red-950/80 text-red-400 border border-red-500/40 uppercase whitespace-nowrap">Vencida</span>`
                            : `<span class="px-1.5 py-0.5 text-[9px] font-bold rounded bg-emerald-950/80 text-emerald-400 border border-emerald-500/40 uppercase whitespace-nowrap">Vigente</span>`;

                        return `
                            <div class="inline-flex flex-wrap items-center gap-1.5 bg-gray-900/90 px-2 py-1.5 rounded-md border border-gray-700/60 mr-1.5 mb-1.5 shadow-sm max-w-full">
                                <span class="px-1.5 py-0.5 text-[10px] font-bold rounded bg-red-500/10 text-red-400 border border-red-500/20 uppercase whitespace-nowrap">
                                    ${lic.clase}
                                </span>
                                <span class="text-xs font-mono text-gray-300 whitespace-nowrap">${lic.no_licencia || 'S/N'}</span>
                                <span class="text-[10px] font-mono whitespace-nowrap ${estaVencida ? 'text-red-400 font-bold' : 'text-gray-400'}">
                                    (${fechaVenc})
                                </span>
                                ${badgeEstado}
                                <button type="button" onclick="eliminarLicencia(${lic.id})" class="text-gray-500 hover:text-red-400 text-xs px-1 cursor-pointer transition" title="Eliminar solo esta licencia">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>
                            </div>
                        `;
                    }).join('');
                }

                fila.innerHTML = `
                    <td class="py-3 px-4 font-semibold text-white min-w-[150px]">
                        ${u.nombres} ${u.apellidos}
                    </td>
                    <td class="py-3 px-4 font-mono text-xs text-gray-300 whitespace-nowrap">
                        ${u.dui || 'N/A'}
                    </td>
                    <td class="py-3 px-4 min-w-[260px]">
                        ${htmlLicencias}
                    </td>
                    <td class="py-3 px-4 min-w-[140px]">
                        <div class="flex items-center justify-start gap-1.5 flex-wrap">
                            <button type="button" onclick='abrirModalAgregarLicencia(${JSON.stringify(u)})' class="text-[11px] bg-emerald-950/40 hover:bg-emerald-700 text-emerald-400 hover:text-white px-2 py-1 rounded-lg border border-emerald-900/30 transition flex items-center gap-1 cursor-pointer whitespace-nowrap">
                                <i class="fa-solid fa-plus text-[9px]"></i> Licencia
                            </button>
                            <button type="button" onclick="abrirModalEditar(${u.id})" class="text-[11px] bg-blue-600/10 hover:bg-blue-600 text-blue-400 hover:text-white px-2 py-1 rounded-lg border border-blue-500/20 transition flex items-center gap-1 cursor-pointer whitespace-nowrap">
                                <i class="fa-solid fa-pen text-[9px]"></i> Editar
                            </button>
                            <button type="button" onclick="eliminarConductor(${u.id})" class="text-[11px] bg-red-950/40 hover:bg-red-700 text-red-500 hover:text-white px-2 py-1 rounded-lg border border-red-900/30 transition flex items-center gap-1 cursor-pointer whitespace-nowrap">
                                <i class="fa-solid fa-trash text-[9px]"></i>
                            </button>
                        </div>
                    </td>
                `;
                tabla.appendChild(fila);
            });

            const total = usuariosFiltrados.length;
            const desde = indexInicial + 1;
            const hasta = Math.min(indexFinal, total);
            
            infoPaginas.textContent = `Mostrando ${desde} a ${hasta} de ${total} conductores`;
            btnPrev.disabled = paginaActual === 1;
            btnNext.disabled = indexFinal >= total;
        }

        buscador.addEventListener('input', (e) => {
            const query = e.target.value.toLowerCase().trim();
            usuariosFiltrados = todosLosUsuarios.filter(u => {
                const coincideNombre = u.nombres.toLowerCase().includes(query) || u.apellidos.toLowerCase().includes(query);
                const coincideDui = u.dui && u.dui.includes(query);
                const coincideLicencia = u.licencias && u.licencias.some(l => l.clase.toLowerCase().includes(query) || (l.no_licencia && l.no_licencia.includes(query)));

                return coincideNombre || coincideDui || coincideLicencia;
            });
            paginaActual = 1;
            renderizarTabla();
        });

        btnPrev.addEventListener('click', () => { if (paginaActual > 1) { paginaActual--; renderizarTabla(); } });
        btnNext.addEventListener('click', () => { if ((paginaActual * limitePorPagina) < usuariosFiltrados.length) { paginaActual++; renderizarTabla(); } });

        function toggleMenuMovil() {
            const sidebar = document.getElementById('sidebar-container');
            const overlay = document.getElementById('sidebar-overlay');
            const icono = document.getElementById('icono-hamburguesa');
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
                sidebar.classList.add('translate-x-0');
                overlay.classList.remove('hidden');
                icono.className = "fa-solid fa-xmark";
            } else {
                sidebar.classList.add('-translate-x-full');
                sidebar.classList.remove('translate-x-0');
                overlay.classList.add('hidden');
                icono.className = "fa-solid fa-bars";
            }
        }

        const aplicarMascaraDUI = (e) => {
            let val = e.target.value.replace(/\D/g, '');
            if (val.length > 8) val = val.substring(0, 8) + '-' + val.substring(8, 9);
            e.target.value = val;
        };

        document.getElementById('input-dui').addEventListener('input', aplicarMascaraDUI);
        document.getElementById('edit-dui').addEventListener('input', aplicarMascaraDUI);

        function abrirModalEditar(id) {
            const usuario = todosLosUsuarios.find(u => u.id === id);
            if (!usuario) return;

            document.getElementById('form-editar').action = `/conductores/${id}`;
            document.getElementById('edit-nombres').value = usuario.nombres;
            document.getElementById('edit-apellidos').value = usuario.apellidos;
            document.getElementById('edit-dui').value = usuario.dui;

            document.getElementById('modal-editar').classList.remove('hidden');
        }

        function cerrarModalEditar() {
            document.getElementById('modal-editar').classList.add('hidden');
        }

        function eliminarLicencia(id) {
            if (confirm('¿Eliminar únicamente esta licencia?')) {
                const form = document.getElementById('form-eliminar-licencia');
                form.action = `/licencias/${id}`;
                form.submit();
            }
        }

        function eliminarConductor(id) {
            if (confirm('¿Eliminar permanentemente a este conductor y todas sus licencias asociadas?')) {
                const form = document.getElementById('form-eliminar-conductor');
                form.action = `/conductores/${id}`;
                form.submit();
            }
        }

        renderizarTabla();
    </script>
</body>
</html>