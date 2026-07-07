<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENOSA - Registro de Combustible</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-950 text-gray-100 font-sans min-h-screen flex flex-col">

    <!-- BARRA SUPERIOR (NAVBAR) -->
    <nav class="bg-gray-900 border-b border-gray-800 px-6 py-4 shadow-xl flex justify-between items-center fixed top-0 w-full z-50 h-16">
        <div class="flex items-center gap-3">
            <span class="text-lg font-black tracking-wider text-white">RE<span class="text-red-500">NOSA</span></span>
            <span class="text-xs bg-red-950 text-red-400 px-2.5 py-1 rounded font-mono font-bold">PORTAL SUCURSAL</span>
        </div>
        <div class="flex items-center gap-4">
            <span class="text-sm font-medium text-gray-300"><i class="fa-solid fa-user text-red-500 mr-1"></i> {{ Auth::user()->name }}</span>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="text-xs bg-red-600/10 hover:bg-red-600 text-red-400 hover:text-white px-3 py-1.5 rounded-lg border border-red-500/20 transition flex items-center gap-1">
                    <i class="fa-solid fa-right-from-bracket"></i> Salir
                </button>
            </form>
        </div>
    </nav>

    <!-- CONTENEDOR PRINCIPAL -->
    <div class="flex flex-1 pt-16 min-h-screen">
        
        <!-- MENÚ LATERAL IZQUIERDO -->
        <aside class="w-64 bg-gray-900 border-r border-gray-800 p-4 space-y-2 hidden md:block fixed h-[calc(100vh-4rem)] left-0 top-16">
            <div class="space-y-2">
                <!-- 1. CHECKLIST -->
                <a href="/muro" class="w-full text-gray-400 hover:text-white hover:bg-gray-800 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-3 transition duration-200 border border-transparent hover:border-gray-700/50">
                    <i class="fa-solid fa-clipboard-list w-5 text-center text-lg"></i>
                    <span>CheckList</span>
                </a>
                
                <!-- 2. COMBUSTIBLE (ACTIVO) -->
                <a href="/combustible" class="w-full bg-red-600 text-white px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-3 shadow-lg shadow-red-900/20 transition duration-200">
                    <i class="fa-solid fa-gas-pump w-5 text-center text-lg"></i>
                    <span>Combustible</span>
                </a>
                
                <!-- 3. KM DIARIOS -->
                <a href="/km-diarios" class="w-full text-gray-400 hover:text-white hover:bg-gray-800 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-3 transition duration-200 border border-transparent hover:border-gray-700/50">
                    <i class="fa-solid fa-road w-5 text-center text-lg text-blue-500"></i>
                    <span>KM Diarios</span>
                </a>
            </div>
        </aside>

        <!-- CONTENIDO DEL FORMULARIO -->
        <main class="flex-1 md:ml-64 p-8 flex flex-col justify-start items-center overflow-y-auto">
            
            <div class="max-w-3xl w-full">
                @if(session('exito'))
                    <div class="bg-emerald-950 border border-emerald-500 text-emerald-300 p-4 rounded-xl text-sm flex items-center gap-2 mb-6 shadow-lg">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i> {{ session('exito') }}
                    </div>
                @endif

                <div class="bg-gray-900 border border-gray-800 p-8 rounded-2xl shadow-2xl">
                    <div class="mb-6 border-b border-gray-800 pb-4">
                        <h2 class="text-xl font-extrabold text-white flex items-center gap-2">
                            <i class="fa-solid fa-gas-pump text-red-500"></i> Registro de Combustible
                        </h2>
                        <p class="text-xs text-gray-400 mt-1">Llena con precisión los datos del ticket de carga de combustible de la unidad.</p>
                    </div>

                    <form action="{{ route('combustible.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <!-- Dos columnas: Sucursal y Fecha -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- 1. Sucursal -->
                            <div>
                                <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">1. Sucursal *</label>
                                <select name="sucursal" id="sucursal-select" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                                    <option value="">Seleccione la respuesta</option>
                                    @foreach($sucursalesConPlacas as $nombreSucursal => $placas)
                                        <option value="{{ $nombreSucursal }}">{{ $nombreSucursal }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- 2. Fecha -->
                            <div>
                                <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">2. Fecha *</label>
                                <input type="date" name="fecha" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                            </div>
                        </div>

                        <!-- Dos columnas: N° Vale y Placa -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- 3. N° Vale -->
                            <div>
                                <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">3. N° Vale *</label>
                                <input type="number" name="no_vale" min="1" placeholder="Escribe un número mayor o igual a 1" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                            </div>

                            <!-- 4. Placa (Dinamizada con JS) -->
                            <div>
                                <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">4. Placa *</label>
                                <select name="placa" id="placa-select" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                                    <option value="">Seleccione primero una sucursal...</option>
                                </select>
                                <input type="text" name="placa_manual" id="placa-manual-input" placeholder="Escribe la placa manualmente (Ej: C-999999)" class="hidden w-full bg-gray-800 border border-amber-500/50 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-500 transition shadow-inner mt-2 uppercase">
                            </div>
                        </div>

                        <!-- 5. Usuario (ACTUALIZADO A SELECT DINÁMICO) -->
                        <div>
                            <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">5. Usuario (Piloto / Conductor) *</label>
                            <select name="usuario" id="usuario-select" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                                <option value="">Seleccione primero una sucursal...</option>
                            </select>
                        </div>

                        <!-- Dos columnas: Precio Galón y Galonaje -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- 6. Precio Galón -->
                            <div>
                                <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">6. Precio Galón *</label>
                                <input type="number" step="0.01" name="precio_galon" placeholder="El valor debe ser un número" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                            </div>

                            <!-- 7. Galonaje -->
                            <div>
                                <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">7. Galonaje *</label>
                                <input type="number" step="0.01" name="galonaje" placeholder="El valor debe ser un número" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                            </div>
                        </div>

                        <!-- 8. Tipo Gas -->
                        <div>
                            <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-3">8. Tipo Gas *</label>
                            <div class="space-y-2 bg-gray-800/40 p-4 rounded-xl border border-gray-800">
                                <label class="flex items-center gap-3 cursor-pointer group text-sm">
                                    <input type="radio" name="tipo_gas" value="Especial" required class="accent-red-500 h-4 w-4">
                                    <span class="text-gray-300 group-hover:text-white transition">ESPECIAL</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group text-sm">
                                    <input type="radio" name="tipo_gas" value="Regular" class="accent-red-500 h-4 w-4">
                                    <span class="text-gray-300 group-hover:text-white transition">REGULAR</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group text-sm">
                                    <input type="radio" name="tipo_gas" value="Diesel" class="accent-red-500 h-4 w-4">
                                    <span class="text-gray-300 group-hover:text-white transition">DIESEL</span>
                                </label>
                            </div>
                        </div>

                        <!-- Dos columnas: Kilometraje y Área -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- 9. Kilometraje -->
                            <div>
                                <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">9. Kilometraje *</label>
                                <input type="number" name="kilometraje" placeholder="El valor debe ser un número" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                            </div>

                            <!-- 10. Área -->
                            <div>
                                <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">10. Área *</label>
                                <select name="area" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                                    <option value="">Selecciona la respuesta</option>
                                    <option value="Logística">Logística / Distribución</option>
                                    <option value="Ventas">Ventas / Comercial</option>
                                    <option value="Operaciones">Operaciones Internas</option>
                                    <option value="Administración">Administración</option>
                                </select>
                            </div>
                        </div>

                        <!-- Botón para Enviar -->
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3.5 px-4 rounded-xl transition flex items-center justify-center gap-2 text-sm shadow-lg shadow-red-900/30 mt-4">
                            <i class="fa-solid fa-floppy-disk"></i> Guardar Registro de Combustible
                        </button>
                    </form>
                </div>
            </div>

        </main>
    </div>

<script>
    const datosFlota = @json($sucursalesConPlacas);
    const datosUsuarios = @json($usuariosPorSucursal);

    const sucursalSelect = document.getElementById('sucursal-select');
    const placaSelect = document.getElementById('placa-select');
    const placaManualInput = document.getElementById('placa-manual-input');
    const usuarioSelect = document.getElementById('usuario-select');

    // 1. Manejo al cambiar de Sucursal
    sucursalSelect.addEventListener('change', function() {
        const sucursalSeleccionada = this.value;

        // Resetear campo manual por si acaso
        placaManualInput.classList.add('hidden');
        placaManualInput.removeAttribute('required');
        placaManualInput.value = '';

        // Renderizar Placas
        placaSelect.innerHTML = '<option value="">Seleccione una placa...</option>';
        if (sucursalSeleccionada && datosFlota[sucursalSeleccionada]) {
            datosFlota[sucursalSeleccionada].forEach(placa => {
                const option = document.createElement('option');
                option.value = placa;
                option.textContent = placa;
                placaSelect.appendChild(option);
            });
            
            // 🌟 Agregamos la opción comodín al final de la lista
            const optionOtro = document.createElement('option');
            optionOtro.value = 'OTRO';
            optionOtro.textContent = '➕ OTRO (Ingresar manualmente)';
            placaSelect.appendChild(optionOtro);

        } else {
            placaSelect.innerHTML = '<option value="">Seleccione primero una sucursal...</option>';
        }

        // Renderizar Usuarios / Pilotos
        usuarioSelect.innerHTML = '<option value="">Seleccione un piloto...</option>';
        if (sucursalSeleccionada && datosUsuarios[sucursalSeleccionada]) {
            datosUsuarios[sucursalSeleccionada].forEach(usuario => {
                const option = document.createElement('option');
                option.value = usuario;
                option.textContent = usuario;
                usuarioSelect.appendChild(option);
            });
        } else {
            usuarioSelect.innerHTML = '<option value="">Seleccione primero una sucursal...</option>';
        }
    });

    // 2. 🌟 Detectar si eligen "OTRO" para mostrar u ocultar el input de texto
    placaSelect.addEventListener('change', function() {
        if (this.value === 'OTRO') {
            placaManualInput.classList.remove('hidden');
            placaManualInput.setAttribute('required', 'required'); // Se vuelve obligatorio escribirla
            placaManualInput.focus();
        } else {
            placaManualInput.classList.add('hidden');
            placaManualInput.removeAttribute('required');
            placaManualInput.value = '';
        }
    });
</script>

</body>
</html>