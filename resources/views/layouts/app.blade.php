<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENOSA - @yield('titulo', 'Portal Sucursal')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-950 text-gray-100 font-sans min-h-screen flex flex-col m-0 p-0 relative">

    <nav class="bg-gray-900 border-b border-gray-800 px-4 md:px-6 py-4 shadow-xl flex justify-between items-center fixed top-0 w-full z-50 h-16">
        <div class="flex items-center gap-3">
            <button id="btn-toggle-menu" class="text-gray-300 hover:text-white text-xl p-2 focus:outline-none md:hidden block cursor-pointer">
                <i class="fa-solid fa-bars"></i>
            </button>
            <img src="https://lh3.googleusercontent.com/d/1AlBG27NmFnim8krD4_bb1aUWEdSLUlB3" alt="Logo RENOSA" class="h-10 md:h-12 w-auto object-contain">    
            <span class="text-[10px] md:text-xs bg-red-950 text-red-400 px-2.5 py-1 rounded font-mono font-bold whitespace-nowrap">PORTAL SUCURSAL</span>
        </div>

        <div class="flex items-center gap-2 md:gap-4">
            <span class="text-xs md:text-sm font-medium text-gray-300 max-w-[120px] md:max-w-none truncate">
                <i class="fa-solid fa-user text-red-500 mr-1"></i> {{ Auth::user()->name }}
            </span>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="text-[11px] md:text-xs bg-red-600/10 hover:bg-red-600 text-red-400 hover:text-white px-2.5 py-1.5 rounded-lg border border-red-500/20 transition flex items-center gap-1 cursor-pointer">
                    <i class="fa-solid fa-right-from-bracket"></i> <span class="hidden sm:inline">Salir</span>
                </button>
            </form>
        </div>
    </nav>

    <div id="mobile-menu" class="fixed inset-0 bg-gray-950/80 z-40 hidden transition-all duration-300 md:hidden">
        <div class="w-72 bg-gray-900 h-full p-5 pt-20 flex flex-col justify-between border-r border-gray-800 shadow-2xl">
            <div class="space-y-4">
                <h3 class="text-xs uppercase tracking-wider text-gray-500 font-mono font-bold px-2">Navegación Sucursal</h3>
                <nav class="space-y-1">
                    <a href="/muro" class="w-full {{ Request::is('muro*') ? 'bg-red-600 text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }} px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-3 transition">
                        <i class="fa-solid fa-clipboard-list w-5 text-center text-lg"></i>
                        <span>CheckList</span>
                    </a>
                    <a href="/combustible" class="w-full {{ Request::is('combustible*') ? 'bg-red-600 text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }} px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-3 transition">
                        <i class="fa-solid fa-gas-pump w-5 text-center text-lg"></i>
                        <span>Combustible</span>
                    </a>
                    <a href="/km-diarios" class="w-full {{ Request::is('km-diarios*') ? 'bg-red-600 text-white' : 'text-gray-400 hover:text-white hover:bg-gray-800' }} px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-3 transition">
                        <i class="fa-solid fa-road w-5 text-center text-lg text-blue-500"></i>
                        <span>KM Diarios</span>
                    </a>
                </nav>
            </div>
            <div class="text-center text-[10px] text-gray-600 font-mono">RENOSA © 2026</div>
        </div>
    </div>

    <div class="flex flex-1 pt-16 w-full">
        <aside class="w-64 bg-gray-900 border-r border-gray-800 p-4 space-y-2 hidden md:flex flex-col fixed h-[calc(100vh-4rem)] left-0 top-16 z-30">
            <div class="space-y-2">
                <a href="/muro" class="w-full {{ Request::is('muro*') ? 'bg-red-600 text-white shadow-lg shadow-red-900/20' : 'text-gray-400 hover:text-white hover:bg-gray-800 border border-transparent hover:border-gray-700/50' }} px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-3 transition duration-200">
                    <i class="fa-solid fa-clipboard-list w-5 text-center text-lg"></i>
                    <span>CheckList</span>
                </a>
                <a href="/combustible" class="w-full {{ Request::is('combustible*') ? 'bg-red-600 text-white shadow-lg shadow-red-900/20' : 'text-gray-400 hover:text-white hover:bg-gray-800 border border-transparent hover:border-gray-700/50' }} px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-3 transition duration-200">
                    <i class="fa-solid fa-gas-pump w-5 text-center text-lg"></i>
                    <span>Combustible</span>
                </a>
                <a href="/km-diarios" class="w-full {{ Request::is('km-diarios*') ? 'bg-red-600 text-white shadow-lg shadow-red-900/20' : 'text-gray-400 hover:text-white hover:bg-gray-800 border border-transparent hover:border-gray-700/50' }} px-4 py-3 rounded-xl text-sm font-medium flex items-center gap-3 transition duration-200">
                    <i class="fa-solid fa-road w-5 text-center text-lg text-blue-500"></i>
                    <span>KM Diarios</span>
                </a>
            </div>
        </aside>

        <main class="flex-1 w-full md:ml-64 p-4 md:p-8 flex flex-col justify-start items-center overflow-x-hidden">
            @yield('contenido')
        </main>
    </div>

    <script>
        const btnToggleMenu = document.getElementById('btn-toggle-menu');
        const mobileMenu = document.getElementById('mobile-menu');
        if (btnToggleMenu && mobileMenu) {
            btnToggleMenu.addEventListener('click', function(e) {
                e.stopPropagation();
                mobileMenu.classList.toggle('hidden');
            });
            mobileMenu.addEventListener('click', function(e) {
                if (e.target === mobileMenu) {
                    mobileMenu.classList.add('hidden');
                }
            });
        }
    </script>

    @stack('scripts')

</body>
</html>