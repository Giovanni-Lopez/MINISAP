<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENOSA - Panel de Checklist</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-950 text-gray-100 font-sans min-h-screen flex flex-col">

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

    <div class="flex flex-1 pt-16 min-h-screen">
        
        <!-- MENÚ LATERAL IZQUIERDO REESTRUCTURADO Y HABILITADO -->
        <aside class="w-64 bg-gray-900 border-r border-gray-800 p-4 space-y-2 hidden md:block fixed h-[calc(100vh-4rem)] left-0 top-16">
            <div class="space-y-2">
                
                <!-- 1. CHECKLIST (ACTIVO) -->
                <a href="/muro" class="w-full bg-red-600 text-white px-4 py-3 rounded-xl text-sm font-bold flex items-center gap-3 shadow-lg shadow-red-900/20 transition duration-200">
                    <i class="fa-solid fa-clipboard-list w-5 text-center text-lg"></i>
                    <span>CheckList</span>
                </a>
                
                <!-- 2. COMBUSTIBLE (HABILITADO PARA EL FUTURO FORMULARIO) -->
                <a href="/combustible" class="w-full text-gray-400 hover:text-white hover:bg-gray-800 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-3 transition duration-200 border border-transparent hover:border-gray-700/50">
                    <i class="fa-solid fa-gas-pump w-5 text-center text-lg text-amber-500"></i>
                    <span>Combustible</span>
                </a>
                
                <!-- 3. KM DIARIOS (HABILITADO PARA EL FUTURO FORMULARIO) -->
                <a href="/km-diarios" class="w-full text-gray-400 hover:text-white hover:bg-gray-800 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-3 transition duration-200 border border-transparent hover:border-gray-700/50">
                    <i class="fa-solid fa-road w-5 text-center text-lg text-blue-500"></i>
                    <span>KM Diarios</span>
                </a>

            </div>
        </aside>

        <main class="flex-1 md:ml-64 p-8 flex flex-col justify-start items-center overflow-y-auto">
            
            <div class="max-w-3xl w-full">
                @if(session('exito'))
                    <div class="bg-emerald-950 border border-emerald-500 text-emerald-300 p-4 rounded-xl text-sm flex items-center gap-2 mb-6 shadow-lg">
                        <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i> {{ session('exito') }}
                    </div>
                @endif

                <div class="bg-gray-900 border border-gray-800 p-8 rounded-2xl shadow-2xl">
                    <div class="mb-6">
                        <h2 class="text-xl font-extrabold text-white flex items-center gap-2">
                            <i class="fa-solid fa-pen-to-square text-red-500"></i> Registrar Nueva Incidencia
                        </h2>
                        <p class="text-xs text-gray-400 mt-1">Reporta problemas logísticos, fallas en sucursales o trabas operativas inmediatamente.</p>
                    </div>

                    <form action="{{ route('incidencias.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf

                        <div>
                            <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Sucursal Afectada</label>
                            <select name="sucursal" id="sucursal-select" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                                <option value="">Seleccione Sucursal...</option>
                                @foreach($sucursalesConPlacas as $nombreSucursal => $placas)
                                    <option value="{{ $nombreSucursal }}">{{ $nombreSucursal }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Placa del Vehículo (Opcional)</label>
                            <select name="placa" id="placa-select" class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                                <option value="">Seleccione primero una sucursal...</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Nivel de Urgencia</label>
                            <select name="urgencia" required class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition shadow-inner">
                                <option value="Baja">🟢 Baja (Afectación mínima)</option>
                                <option value="Media" selected>🟡 Media (Afectación parcial)</option>
                                <option value="Alta">🟠 Alta (Traba operativa grave)</option>
                                <option value="Crítica">🔴 Crítica (Operación detenida)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Descripción del "Lamento"</label>
                            <textarea name="descripcion" rows="4" required placeholder="Describe detalladamente el problema con la carga, equipo o retraso..." class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-sm text-white focus:outline-none focus:border-red-500 transition placeholder-gray-600 shadow-inner resize-none"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-mono uppercase tracking-wider text-gray-400 mb-2">Evidencia Fotográfica (Opcional)</label>
                            <input type="file" name="imagen_evidencia" accept="image/*" class="w-full text-sm text-gray-400 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-gray-800 file:text-gray-200 hover:file:bg-gray-700 file:transition cursor-pointer">
                        </div>

                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-3.5 px-4 rounded-xl transition flex items-center justify-center gap-2 text-sm shadow-lg shadow-red-900/30">
                            <i class="fa-solid fa-paper-plane"></i> Publicar Reporte en el Muro
                        </button>
                    </form>
                </div>
            </div>

        </main>
    </div>

    <script>
        const datosFlota = @json($sucursalesConPlacas);
        const sucursalSelect = document.getElementById('sucursal-select');
        const placaSelect = document.getElementById('placa-select');

        sucursalSelect.addEventListener('change', function() {
            const sucursalSeleccionada = this.value;
            placaSelect.innerHTML = '<option value="">Ninguno / No aplica</option>';
            
            if (sucursalSeleccionada && datosFlota[sucursalSeleccionada]) {
                datosFlota[sucursalSeleccionada].forEach(placa => {
                    const option = document.createElement('option');
                    option.value = placa;
                    option.textContent = placa;
                    placaSelect.appendChild(option);
                });
            }
        });
    </script>

</body>
</html>