<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENOSA - @yield('titulo', 'Portal Sucursal')</title>   
    <!-- Alpine.js para control del menú -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ sidebarOpen: window.innerWidth >= 768 }" class="bg-gray-950 text-gray-100 font-sans min-h-screen flex flex-col m-0 p-0 relative">

    <nav class="bg-gray-900 border-b border-gray-800 px-4 md:px-6 py-4 shadow-xl flex justify-between items-center fixed top-0 w-full z-50 h-16">
    <div class="flex items-center gap-3">
        <!-- BOTÓN HAMBURGUESA GENERAL -->
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-300 hover:text-white text-xl p-2 focus:outline-none cursor-pointer">
            <i class="fa-solid fa-bars"></i>
        </button>
        
        <!-- LOGO RENOSA LOCAL -->
        <img src="{{ asset('images/renosaLogo.png') }}" alt="Logo RENOSA" class="h-10 w-auto object-contain">
        
        <!-- Etiqueta dinámica de rol -->
        <span class="text-[10px] md:text-xs {{ Auth::user()->role === 'admin' ? 'bg-red-950 text-red-400' : 'bg-emerald-950 text-emerald-400' }} px-2.5 py-1 rounded font-mono font-bold whitespace-nowrap uppercase">
            PORTAL {{ Auth::user()->role === 'admin' ? 'ADMIN' : (Auth::user()->role === 'coordinador' ? 'COORDINADOR' : 'GESTOR') }}
        </span>
    </div>

    <div class="flex items-center gap-2 md:gap-4">
        <span class="text-xs md:text-sm font-medium text-gray-300 max-w-[120px] md:max-w-none truncate">
            <i class="fa-solid fa-user {{ Auth::user()->role === 'admin' ? 'text-red-500' : 'text-emerald-500' }} mr-1"></i> {{ Auth::user()->name }}
        </span>
        
        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button type="submit" class="text-[11px] md:text-xs bg-red-600/10 hover:bg-red-600 text-red-400 hover:text-white px-2.5 py-1.5 rounded-lg border border-red-500/20 transition flex items-center gap-1 cursor-pointer">
                <i class="fa-solid fa-right-from-bracket"></i> 
                <span class="hidden sm:inline">Salir</span>
            </button>
        </form>
    </div>
</nav>

    <!-- OVERLAY OSCURO PARA PANTALLAS MÓVILES -->
    <div x-show="sidebarOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false" 
         class="fixed inset-0 bg-gray-950/80 z-40 md:hidden backdrop-blur-xs">
    </div>

    <!-- CONTENEDOR PRINCIPAL Y SIDEBAR -->
    <div class="flex flex-1 pt-16 w-full">
        <!-- BARRA LATERAL (SIDEBAR) -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
               class="w-64 bg-gray-900 border-r border-gray-800 flex flex-col fixed h-[calc(100vh-4rem)] left-0 top-16 z-50 md:z-30 transition-transform duration-300 ease-in-out">
            
           @include('layouts.sidebar')

        </aside>

        <!-- CONTENIDO PRINCIPAL ADAPTABLE -->
        <main :class="sidebarOpen ? 'md:ml-64' : 'md:ml-0'" class="flex-1 w-full p-4 md:p-8 flex flex-col justify-start items-center overflow-x-hidden transition-all duration-300">
            @yield('contenido')
        </main>
    </div>

    @stack('scripts')

</body>
</html>