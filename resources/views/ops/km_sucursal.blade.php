<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENOSA - KM Diarios</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-950 text-gray-100 font-sans min-h-screen flex flex-col">

    <!-- BARRA SUPERIOR -->
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
                <a href="/muro" class="w-full text-gray-400 hover:text-white hover:bg-gray-800 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-3 transition duration-200 border border-transparent hover:border-gray-700/50">
                    <i class="fa-solid fa-clipboard-list w-5 text-center text-lg"></i>
                    <span>CheckList</span>
                </a>
                <a href="/combustible" class="w-full text-gray-400 hover:text-white hover:bg-gray-800 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-3 transition duration-200 border border-transparent hover:border-gray-700/50">
                    <i class="fa-solid fa-gas-pump w-5 text-center text-lg text-amber-500"></i>
                    <span>Combustible</span>
                </a>
                <!-- KM DIARIOS (ACTIVO) -->
                <a href="/km-diarios" class="w-full bg-red-600 text-white px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-3 shadow-lg shadow-red-900/20 transition duration-200">
                    <i class="fa-solid fa-road w-5 text-center text-lg"></i>
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
                            <i class="fa-solid fa-road text-blue-500"></i> Control de Kilometraje Diario
                        </h2>
                        <p class="text-xs text-gray-400 mt-1">Registra las lecturas iniciales y finales para calcular el recorrido diario de la unidad.</p>
                    </div>

                    <form action="{{ route('km.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <!-- 1. Sucursal y Placa -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">1. Sucursal *</label>
                                <select name="sucursal" id="sucursal-select" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                                    <option value="">Seleccione Sucursal...</option>
                                    @foreach($sucursalesConPlacas as $nombreSucursal => $placas)
                                        <option value="{{ $nombreSucursal }}">{{ $nombreSucursal }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">2. Placa de la Unidad *</label>
                                <select name="placa" id="placa-select" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                                    <option value="">Seleccione primero una sucursal...</option>
                                </select>
                                <input type="text" name="placa_manual" id="placa-manual-input" placeholder="Escribe la placa manualmente" class="hidden w-full bg-gray-800 border border-amber-500/50 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-amber-500 transition shadow-inner mt-2 uppercase">
                            </div>
                        </div>

                        <!-- 2. Kilometraje Inicial y Kilometraje Final -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">3. Kilometraje Inicial (Salida) *</label>
                                <input type="number" id="km-inicial" name="km_inicial" placeholder="Lectura al iniciar el día" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                            </div>

                            <div>
                                <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">4. Kilometraje Final (Llegada) *</label>
                                <input type="number" id="km-final" name="km_final" placeholder="Lectura al finalizar la ruta" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                            </div>
                        </div>

                        <!-- 3. Kilómetros Totales Recorridos (CÁLCULO AUTOMÁTICO EN TIEMPO REAL) -->
                        <div class="bg-gray-950 p-5 rounded-xl border border-gray-800 flex items-center justify-between">
                            <div>
                                <h4 class="text-xs font-mono uppercase tracking-wider text-gray-400">Total Recorrido en el Día</h4>
                                <p class="text-xs text-gray-500 mt-0.5">(Calculado en tiempo real)</p>
                            </div>
                            <div class="text-right">
                                <span id="km-total-display" class="text-3xl font-black text-blue-400 tracking-tight">0</span>
                                <span class="text-xs font-mono text-gray-400 ml-1">KM</span>
                            </div>
                        </div>

                        <!-- Botón de Envío -->
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 px-4 rounded-xl transition flex items-center justify-center gap-2 text-sm shadow-lg shadow-blue-900/30 mt-2">
                            <i class="fa-solid fa-road-circle-check"></i> Registrar Kilometraje Diario
                        </button>
                    </form>
                </div>
            </div>

        </main>
    </div>

    <!-- SCRIPTS -->
    <script>
        const datosFlota = @json($sucursalesConPlacas);
        const sucursalSelect = document.getElementById('sucursal-select');
        const placaSelect = document.getElementById('placa-select');
        const placaManualInput = document.getElementById('placa-manual-input');

        // Lógica de Flotas Dinámicas + Opción "OTRO"
        sucursalSelect.addEventListener('change', function() {
            const sucursalSeleccionada = this.value;
            placaManualInput.classList.add('hidden');
            placaManualInput.removeAttribute('required');
            placaManualInput.value = '';

            placaSelect.innerHTML = '<option value="">Seleccione una placa...</option>';
            if (sucursalSeleccionada && datosFlota[sucursalSeleccionada]) {
                datosFlota[sucursalSeleccionada].forEach(placa => {
                    const option = document.createElement('option');
                    option.value = placa;
                    option.textContent = placa;
                    placaSelect.appendChild(option);
                });
                const optionOtro = document.createElement('option');
                optionOtro.value = 'OTRO';
                optionOtro.textContent = '➕ OTRO (Ingresar manualmente)';
                placaSelect.appendChild(optionOtro);
            } else {
                placaSelect.innerHTML = '<option value="">Seleccione primero una sucursal...</option>';
            }
        });

        placaSelect.addEventListener('change', function() {
            if (this.value === 'OTRO') {
                placaManualInput.classList.remove('hidden');
                placaManualInput.setAttribute('required', 'required');
                placaManualInput.focus();
            } else {
                placaManualInput.classList.add('hidden');
                placaManualInput.removeAttribute('required');
                placaManualInput.value = '';
            }
        });

        // Lógica matemática en tiempo real
        const kmInicialInput = document.getElementById('km-inicial');
        const kmFinalInput = document.getElementById('km-final');
        const kmTotalDisplay = document.getElementById('km-total-display');

        function calcularDiferenciaKM() {
            const inicial = parseFloat(kmInicialInput.value) || 0;
            const final = parseFloat(kmFinalInput.value) || 0;

            if (final >= inicial && inicial > 0) {
                const total = final - inicial;
                kmTotalDisplay.textContent = total.toLocaleString();
                kmTotalDisplay.className = "text-3xl font-black text-blue-400 tracking-tight";
            } else if (final < inicial && final > 0) {
                kmTotalDisplay.textContent = "Error";
                kmTotalDisplay.className = "text-xl font-bold text-red-500 tracking-tight";
            } else {
                kmTotalDisplay.textContent = "0";
                kmTotalDisplay.className = "text-3xl font-black text-blue-400 tracking-tight";
            }
        }

        kmInicialInput.addEventListener('input', calcularDiferenciaKM);
        kmFinalInput.addEventListener('input', calcularDiferenciaKM);
    </script>

</body>
</html>