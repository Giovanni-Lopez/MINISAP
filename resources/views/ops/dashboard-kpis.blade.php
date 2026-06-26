<div class="max-w-7xl mx-auto px-6 pt-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
    
    <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 relative overflow-hidden group hover:scale-[1.02] transition-all duration-300 shadow-lg">
        <div class="flex justify-between items-center">
            <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-500">
                <i class="fa-solid fa-folder-open text-xl"></i>
            </div>
            <span class="text-[10px] font-bold text-gray-400 tracking-widest bg-gray-900/50 px-2 py-1 rounded-md">REPORTES</span>
        </div>
        <div class="mt-4">
            <h3 class="text-3xl font-extrabold text-white font-sans tracking-tight">{{ $incidencias->count() }}</h3>
            <p class="text-xs font-medium text-gray-400 mt-1 uppercase tracking-wider">Total de Incidencias</p>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-[3px] bg-blue-500"></div>
    </div>

    <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 relative overflow-hidden group hover:scale-[1.02] transition-all duration-300 shadow-lg">
        <div class="flex justify-between items-center">
            <div class="w-12 h-12 rounded-xl bg-red-500/10 flex items-center justify-center text-red-500 animate-pulse">
                <i class="fa-solid fa-triangle-exclamation text-xl"></i>
            </div>
            <span class="text-[10px] font-bold text-red-400 tracking-widest bg-red-950/30 px-2 py-1 rounded-md">ALERTA</span>
        </div>
        <div class="mt-4">
            <h3 class="text-3xl font-extrabold text-red-500 font-sans tracking-tight">
                {{-- Filtramos ignorando mayúsculas/minúsculas y tildes comunes --}}
                {{ $incidencias->filter(function($i) {
                    return in_array(strtolower($i->urgencia), ['alta', 'crítica', 'critica', 'alto', 'crítico', 'critico']);
                })->count() }}
            </h3>
            <p class="text-xs font-medium text-gray-400 mt-1 uppercase tracking-wider">Nivel Crítico</p>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-[3px] bg-red-500"></div>
    </div>

    <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 relative overflow-hidden group hover:scale-[1.02] transition-all duration-300 shadow-lg">
        <div class="flex justify-between items-center">
            <div class="w-12 h-12 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-500">
                <i class="fa-solid fa-truck-front text-xl"></i>
            </div>
            <span class="text-[10px] font-bold text-amber-400 tracking-widest bg-amber-950/20 px-2 py-1 rounded-md">FLOTA</span>
        </div>
        <div class="mt-4">
            <h3 class="text-3xl font-extrabold text-amber-500 font-sans tracking-tight">
                {{ $incidencias->whereNotNull('placa')->filter(function($i) { return $i->placa !== ''; })->unique('placa')->count() }}
            </h3>
            <p class="text-xs font-medium text-gray-400 mt-1 uppercase tracking-wider">Placas Afectadas</p>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-[3px] bg-amber-500"></div>
    </div>

    <div class="bg-gray-800 border border-gray-700 rounded-xl p-5 relative overflow-hidden group hover:scale-[1.02] transition-all duration-300 shadow-lg">
        <div class="flex justify-between items-center">
            <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-400">
                <i class="fa-solid fa-square-poll-vertical text-xl"></i>
            </div>
            <span class="text-[10px] font-bold text-emerald-400 tracking-widest bg-emerald-950/20 px-2 py-1 rounded-md">LIVE</span>
        </div>
        <div class="mt-4">
            <h3 class="text-lg font-bold text-emerald-400 flex items-center gap-1.5 mt-2">
                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500 inline-block animate-ping"></span>
                Activo
            </h3>
            <p class="text-xs font-medium text-gray-400 mt-2 uppercase tracking-wider">Estado del Sistema</p>
        </div>
        <div class="absolute bottom-0 left-0 right-0 h-[3px] bg-emerald-500"></div>
    </div>

</div>