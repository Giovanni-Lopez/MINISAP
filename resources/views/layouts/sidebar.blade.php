<div class="flex flex-col justify-between h-full w-full">
    <div class="p-4 space-y-6 overflow-y-auto">
        <nav class="space-y-2">
            
            <!-- 1. CheckList: Visible para TODOS (Gestor, Coordinador, Admin) -->
            <a href="/muro" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ Request::is('muro*') ? 'bg-red-600 text-white shadow-lg shadow-red-900/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <i class="fa-solid fa-clipboard-list w-5 text-center text-lg"></i>
                <span>CheckList</span>
            </a>

            <!-- 2. Combustible y KM Diarios: Visibles SOLO para Coordinador y Admin -->
            @if(in_array(Auth::user()->role, ['coordinador', 'admin']))
                <a href="/combustible" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ Request::is('combustible*') ? 'bg-red-600 text-white shadow-lg shadow-red-900/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fa-solid fa-gas-pump w-5 text-center text-lg"></i>
                    <span>Combustible</span>
                </a>

                <a href="/km-diarios" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ Request::is('km-diarios*') ? 'bg-red-600 text-white shadow-lg shadow-red-900/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                    <i class="fa-solid fa-road w-5 text-center text-lg text-blue-500"></i>
                    <span>KM Diarios</span>
                </a>
            @endif

            <!-- 3. Módulos EXCLUSIVOS para Administrador -->
            @if(Auth::user()->role === 'admin')
                <div class="pt-4 mt-4 border-t border-gray-800/60 space-y-2">
                    <h4 class="text-[10px] uppercase tracking-wider text-gray-600 font-mono font-bold px-4 mb-1">Administración</h4>

                    <!-- Cuentas del Sistema -->
                    <a href="{{ route('gestion-usuarios.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition {{ Request::is('gestion-usuarios*') ? 'bg-red-600 text-white shadow-lg shadow-red-950/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        <i class="fa-solid fa-user-gear w-5 text-center text-lg"></i>
                        <span>Usuarios Sistema</span>
                    </a>

                    @if(Route::has('sucursales.index'))
                        <a href="{{ route('sucursales.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition {{ Request::is('sucursales*') ? 'bg-red-600 text-white shadow-lg shadow-red-950/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                            <i class="fa-solid fa-shop w-5 text-center text-lg"></i>
                            <span>Sucursales</span>
                        </a>
                    @endif

                    @if(Route::has('flota.index'))
                        <a href="{{ route('flota.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('flota.*') ? 'bg-red-600 text-white shadow-lg shadow-red-900/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                            <i class="fa-solid fa-truck-moving w-5 text-center text-lg"></i>
                            <span>Flota</span>
                        </a>
                    @endif

                    <a href="/asignaciones-flota" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-all duration-200 {{ Request::is('asignaciones-flota*') ? 'bg-red-600 text-white shadow-lg shadow-red-900/30' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-100' }}">
                        <i class="fa-solid fa-key w-5 text-center text-lg"></i>
                        <span>Asignaciones</span>
                    </a>

                    <!-- Motoristas Operativos -->
                    <a href="{{ route('conductores.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition {{ Request::is('conductores*') ? 'bg-red-600 text-white shadow-lg shadow-red-950/50' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        <i class="fa-solid fa-id-card w-5 text-center text-lg"></i>
                        <span>Motoristas</span>
                    </a>

                    <a href="{{ route('combustible.historial') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ Request::is('historial*') ? 'bg-red-600 text-white shadow-lg shadow-red-900/20' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        <i class="fa-solid fa-clock-rotate-left w-5 text-center text-lg"></i>
                        <span>Historial</span>
                    </a>
                </div>
            @endif
        </nav>
    </div>

    <!-- PIE DEL SIDEBAR -->
    <div class="p-4 border-t border-gray-800 bg-gray-900/20 space-y-4">
        <form action="{{ route('logout') }}" method="POST" class="w-full m-0">
            @csrf
            <button type="submit" class="w-full text-gray-400 hover:text-white hover:bg-red-600/20 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-3 transition duration-200 border border-transparent hover:border-red-500/30 cursor-pointer">
                <i class="fa-solid fa-right-from-bracket w-5 text-center text-lg text-red-500"></i>
                <span>Cerrar Sesión</span>
            </button>
        </form>

        <div class="text-center text-xs text-gray-600 font-mono pt-2 border-t border-gray-800">
            RENOSA © 2026
        </div>
    </div>
</div>