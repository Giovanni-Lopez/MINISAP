<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENOSA - Control de Usuarios</title>
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
                
                <!-- Encabezado con Botón de Registro -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
                    <h2 class="text-xl md:text-2xl font-black text-white flex items-center gap-2">
                        <i class="fa-solid fa-users-gear text-red-500"></i> Control y Registro de Usuarios
                    </h2>
                    <button onclick="abrirModalRegistrar()" class="bg-red-600 hover:bg-red-700 transition text-white text-xs md:text-sm font-bold py-2 px-4 rounded-lg flex items-center gap-2 shadow-lg shadow-red-900/20 self-start sm:self-auto cursor-pointer">
                        <i class="fa-solid fa-user-plus"></i> Registrar Nuevo Usuario
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
                                    <i class="fa-solid fa-address-book text-gray-400"></i> Personal Registrado
                                </h3>
                                <div class="relative w-full sm:w-72">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fa-solid fa-magnifying-glass text-gray-500 text-sm"></i>
                                    </span>
                                    <input type="text" id="buscador" placeholder="Buscar por nombre, DUI, licencia..." class="w-full bg-gray-900 border border-gray-700 rounded-lg pl-9 pr-4 py-2 text-xs focus:outline-none focus:border-red-500 text-white placeholder-gray-500">
                                </div>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm border-collapse table-fixed">
                                    <thead>
                                        <tr class="border-b border-gray-700 text-xs font-mono text-gray-400 uppercase">
                                            <th class="py-3 px-4 w-[25%]">Nombre Completo</th>
                                            <th class="py-3 px-4 w-[15%]">DUI</th>
                                            <th class="py-3 px-4 w-[20%]">Licencia</th>
                                            <th class="py-3 px-4 w-[15%]">Vencimiento</th>
                                            <th class="py-3 px-4 text-left w-[25%]">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla-usuarios" class="divide-y divide-gray-700/50">
                                        <!-- Renderizado dinámico vía JS -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Paginación -->
                        <div class="flex items-center justify-between border-t border-gray-700/50 pt-4 mt-4">
                            <span id="info-paginas" class="text-xs text-gray-400 font-mono">Mostrando 0 a 0 de 0 usuarios</span>
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

    <!-- MODAL: REGISTRAR USUARIO -->
    <div id="modal-registrar" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-sm px-4 overflow-y-auto">
        <div class="bg-gray-900 border border-gray-800 w-full max-w-xl rounded-2xl p-6 shadow-2xl relative my-8">
            
            <button onclick="cerrarModalRegistrar()" class="absolute top-4 right-4 text-gray-500 hover:text-white transition cursor-pointer">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>

            <h3 class="text-lg font-black text-white flex items-center gap-2 mb-4">
                <i class="fa-solid fa-user-plus text-red-500"></i> Registrar Nuevo Usuario
            </h3>

            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-3 max-h-[65vh] overflow-y-auto pr-1">
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Nombres *</label>
                        <input type="text" name="nombres" required placeholder="Ej: Juan Antonio" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Apellidos *</label>
                        <input type="text" name="apellidos" required placeholder="Ej: Pérez Quintanilla" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">DUI *</label>
                        <input type="text" name="dui" id="input-dui" required placeholder="00000000-0" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500 font-mono">
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">No. Licencia *</label>
                        <input type="text" name="no_licencia" placeholder="0000-000000-000-0" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500 font-mono">
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
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Fecha de Vencimiento *</label>
                        <input type="date" name="vence" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500 font-mono">
                    </div>

                    <!-- CAMPO DINÁMICO PARA "OTROS" -->
                    <div id="contenedor-otra-clase" class="col-span-2 hidden">
                        <label class="block text-xs font-mono uppercase tracking-wider text-red-400 mb-1">Escriba la otra clase de licencia *</label>
                        <input type="text" name="otra_clase" id="otra_clase" placeholder="Ej: TRACTOR, PESADA T" class="w-full bg-gray-800 border border-red-900/50 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-red-500 uppercase">
                    </div>
                </div>

                <div class="flex gap-2 pt-4 border-t border-gray-800 mt-4">
                    <button type="button" onclick="cerrarModalRegistrar()" class="w-1/2 bg-gray-800 hover:bg-gray-700 text-gray-300 font-semibold py-2.5 rounded-xl transition text-sm">
                        Cancelar
                    </button>
                    <button type="submit" class="w-1/2 bg-red-600 hover:bg-red-700 text-white font-bold py-2.5 rounded-xl transition flex items-center justify-center gap-2 text-sm shadow-lg shadow-red-900/30">
                        <i class="fa-solid fa-save"></i> Guardar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: EDITAR USUARIO -->
    <div id="modal-editar" class="hidden fixed inset-0 z-[100] flex items-center justify-center bg-black/70 backdrop-blur-sm px-4 overflow-y-auto">
        <div class="bg-gray-900 border border-gray-800 w-full max-w-xl rounded-2xl p-6 shadow-2xl relative my-8">
            
            <button type="button" onclick="cerrarModalEditar()" class="absolute top-4 right-4 text-gray-500 hover:text-white transition cursor-pointer">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>

            <h3 class="text-lg font-black text-white flex items-center gap-2 mb-4">
                <i class="fa-solid fa-user-pen text-blue-500"></i> Editar Usuario
            </h3>

            <!-- La acción del formulario se cambiará dinámicamente con JS -->
            <form id="form-editar" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-3 max-h-[65vh] overflow-y-auto pr-1">
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
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">No. Licencia *</label>
                        <input type="text" name="no_licencia" id="edit-no-licencia" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500 font-mono">
                    </div>

                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Clase de Licencia *</label>
                        <select name="clase_select" id="edit-clase-select" onchange="evaluarClaseLicenciaEditar(this.value)" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500">
                            <option value="D LIVIANA">D LIVIANA</option>
                            <option value="C PESADA">C PESADA</option>
                            <option value="A MOTOCICLETA">A MOTOCICLETA</option>
                            <option value="OTROS">OTROS (Especificar)</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-1">Fecha de Vencimiento *</label>
                        <input type="date" name="vence" id="edit-vence" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500 font-mono">
                    </div>

                    <!-- CAMPO DINÁMICO PARA "OTROS" EN EDICIÓN -->
                    <div id="contenedor-otra-clase-edit" class="col-span-2 hidden">
                        <label class="block text-xs font-mono uppercase tracking-wider text-blue-400 mb-1">Escriba la otra clase de licencia *</label>
                        <input type="text" name="otra_clase" id="edit-otra-clase" placeholder="Ej: TRACTOR" class="w-full bg-gray-800 border border-blue-900/50 rounded-xl px-3 py-2 text-sm text-white focus:outline-none focus:border-blue-500 uppercase">
                    </div>
                </div>

                <div class="flex gap-2 pt-4 border-t border-gray-800 mt-4">
                    <button type="button" onclick="cerrarModalEditar()" class="w-1/2 bg-gray-800 hover:bg-gray-700 text-gray-300 font-semibold py-2.5 rounded-xl transition text-sm">
                        Cancelar
                    </button>
                    <button type="submit" class="w-1/2 bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl transition flex items-center justify-center gap-2 text-sm shadow-lg shadow-blue-900/30">
                        <i class="fa-solid fa-save"></i> Actualizar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

   <script>
            // Traemos los usuarios inyectados desde el controlador de Laravel
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
                document.getElementById('modal-registrar').classList.remove('hidden');
            }
            
            function cerrarModalRegistrar() {
                document.getElementById('modal-registrar').classList.add('hidden');
            }

            // Evalúa si se selecciona "OTROS" para mostrar el input de texto manual
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

            // Renderizado Dinámico de la Tabla en pantalla completa
            function renderizarTabla() {
                const indexInicial = (paginaActual - 1) * limitePorPagina;
                const indexFinal = indexInicial + limitePorPagina;
                const itemsPagina = usuariosFiltrados.slice(indexInicial, indexFinal);

                tabla.innerHTML = '';

                if (itemsPagina.length === 0) {
                    tabla.innerHTML = `
                        <tr>
                            <td colspan="5" class="text-center py-8 text-gray-500">
                                <i class="fa-solid fa-user-slash text-2xl mb-2 block"></i>
                                No se encontraron usuarios registrados.
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

                    // Formateo de fecha de vencimiento simple
                    const fechaVence = u.vence ? new Date(u.vence).toLocaleDateString('es-SV', {timeZone: 'UTC'}) : 'S/V';

                    fila.innerHTML = `
                        <td class="py-3 px-4 font-semibold text-white">
                            ${u.nombres} ${u.apellidos}
                        </td>
                        <td class="py-3 px-4 font-mono text-xs text-gray-300">
                            ${u.dui || 'N/A'}
                        </td>
                        <td class="py-3 px-4">
                            <div class="text-[11px] font-mono">
                                <span class="px-2 py-0.5 rounded bg-red-500/10 text-red-400 border border-red-500/20 font-bold block w-fit mb-1">
                                    ${u.clase}
                                </span>
                                <span class="text-gray-500 text-[10px]">No: ${u.no_licencia || 'S/N'}</span>
                            </div>
                        </td>
                        <td class="py-3 px-4 font-mono text-xs text-gray-300">
                            ${fechaVence}
                        </td>
                        <td class="py-3 px-4">
                            <div class="flex items-center justify-start gap-1.5 flex-wrap">
                                <!-- MODIFICADO: Ahora ejecuta abrirModalEditar pasando el ID -->
                                <button type="button" onclick="abrirModalEditar(${u.id})" class="text-[11px] bg-blue-600/10 hover:bg-blue-600 text-blue-400 hover:text-white px-2.5 py-1 rounded-lg border border-blue-500/20 transition flex items-center gap-1 cursor-pointer">
                                    <i class="fa-solid fa-user-pen text-[9px]"></i> Editar
                                </button>
                                <form action="/usuarios/${u.id}" method="POST" class="inline" onsubmit="return confirm('¿Eliminar permanentemente a este usuario?');">
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

                const total = usuariosFiltrados.length;
                const desde = indexInicial + 1;
                const hasta = Math.min(indexFinal, total);
                
                infoPaginas.textContent = `Mostrando ${desde} a ${hasta} de ${total} usuarios`;
                btnPrev.disabled = paginaActual === 1;
                btnNext.disabled = indexFinal >= total;
            }

            // Buscador reactivo local
            buscador.addEventListener('input', (e) => {
                const query = e.target.value.toLowerCase().trim();
                usuariosFiltrados = todosLosUsuarios.filter(u => {
                    return u.nombres.toLowerCase().includes(query) ||
                        u.apellidos.toLowerCase().includes(query) ||
                        (u.dui && u.dui.includes(query)) ||
                        (u.clase && u.clase.toLowerCase().includes(query));
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

            // Máscara básica automática para el DUI (00000000-0)
            document.getElementById('input-dui').addEventListener('input', function (e) {
                let val = e.target.value.replace(/\D/g, '');
                if (val.length > 8) {
                    val = val.substring(0, 8) + '-' + val.substring(8, 9);
                }
                e.target.value = val;
            });

            // NUEVO: Funciones para cargar y controlar el modal de edición
            function abrirModalEditar(id) {
                const usuario = todosLosUsuarios.find(u => u.id === id);
                if (!usuario) return;

                // Cambiamos dinámicamente el action del formulario
                document.getElementById('form-editar').action = `/usuarios/${id}`;

                // Cargamos los datos en los inputs del modal
                document.getElementById('edit-nombres').value = usuario.nombres;
                document.getElementById('edit-apellidos').value = usuario.apellidos;
                document.getElementById('edit-dui').value = usuario.dui;
                document.getElementById('edit-no-licencia').value = usuario.no_licencia;
                
                // Ajustamos el formato de fecha para el input date
                if (usuario.vence) {
                    document.getElementById('edit-vence').value = usuario.vence.split('T')[0];
                }

                // Comprobamos si es una licencia común o entra en "OTROS"
                const selectClase = document.getElementById('edit-clase-select');
                const inputOtraClase = document.getElementById('edit-otra-clase');
                const contenedorOtros = document.getElementById('contenedor-otra-clase-edit');

                if (['D LIVIANA', 'C PESADA', 'A MOTOCICLETA'].includes(usuario.clase)) {
                    selectClase.value = usuario.clase;
                    contenedorOtros.classList.add('hidden');
                    inputOtraClase.required = false;
                    inputOtraClase.value = '';
                } else {
                    selectClase.value = 'OTROS';
                    contenedorOtros.classList.remove('hidden');
                    inputOtraClase.required = true;
                    inputOtraClase.value = usuario.clase;
                }

                document.getElementById('modal-editar').classList.remove('hidden');
            }

            function cerrarModalEditar() {
                document.getElementById('modal-editar').classList.add('hidden');
            }

            function evaluarClaseLicenciaEditar(valor) {
                const contenedor = document.getElementById('contenedor-otra-clase-edit');
                const input = document.getElementById('edit-otra-clase');
                if (valor === 'OTROS') {
                    contenedor.classList.remove('hidden');
                    input.required = true;
                    input.focus();
                } else {
                    contenedor.classList.add('hidden');
                    input.required = false;
                    input.value = '';
                }
            }

            // Máscara automática de DUI también para el modal editar
            document.getElementById('edit-dui').addEventListener('input', function (e) {
                let val = e.target.value.replace(/\D/g, '');
                if (val.length > 8) val = val.substring(0, 8) + '-' + val.substring(8, 9);
                e.target.value = val;
            });

            // Ejecución inicial de renderizado
            renderizarTabla();
    </script>
</body>
</html>