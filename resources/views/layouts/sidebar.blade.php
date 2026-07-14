<aside class="hidden md:flex w-full md:w-64 bg-gray-800 border-r border-gray-700 flex-col justify-between shrink-0 min-h-[calc(100vh-4rem)]">
    <div class="p-4 space-y-6">
        <nav class="space-y-2">
            <!-- Botón CheckList -->
            <a href="/muro" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->is('muro') ? 'bg-red-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <i class="fa-solid fa-clipboard-list w-5 text-center"></i> CheckList
            </a>

            <!-- Botón Sucursales -->
            <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->is('sucursales') ? 'bg-red-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <i class="fa-solid fa-network-wired w-5 text-center"></i> Sucursales
            </a>

            <!-- Botón Flota / Placas -->
            <a href="{{ route('flota.index') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->routeIs('flota.*') ? 'bg-red-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <i class="fa-solid fa-truck-moving w-5 text-center"></i> Flota / Placas
            </a>

            <!-- Botón Historial -->
            <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl transition-colors {{ request()->is('historial') ? 'bg-red-600 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                <i class="fa-solid fa-clock-history w-5 text-center"></i> Historial
            </a>
        </nav>
    </div>

    <div class="p-4 border-t border-gray-700/60 bg-gray-800/40 space-y-4">
        <form action="{{ route('logout') }}" method="POST" class="w-full m-0">
            @csrf
            <button type="submit" class="w-full text-gray-400 hover:text-white hover:bg-red-600/20 px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-3 transition duration-200 border border-transparent hover:border-red-500/30 cursor-pointer">
                <i class="fa-solid fa-right-from-bracket w-5 text-center text-lg text-red-500"></i>
                <span>Cerrar Sesión</span>
            </button>
        </form>

        <div class="text-center text-xs text-gray-500 font-mono pt-2 border-t border-gray-700/40">
            RENOSA © 2026
        </div>
    </div>
</aside>