<div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6">
    
    <div class="bg-gray-900 border border-gray-800 p-4 rounded-2xl flex items-center justify-between shadow-xl relative overflow-hidden group hover:border-blue-500/40 transition-all duration-300">
        <div class="space-y-1 relative z-10">
            <span class="text-[10px] font-mono uppercase tracking-wider text-gray-400">Control Operativo</span>
            <h3 class="text-2xl font-black text-white tracking-tight">
                {{ $incidencias->where('estado', 'Pendiente')->count() }}
            </h3>
            <p class="text-[11px] text-blue-400 flex items-center gap-1 font-medium">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span> Lamentos Pendientes
            </p>
        </div>
        <div class="w-10 h-10 bg-blue-500/10 rounded-lg flex items-center justify-center text-blue-500 text-sm border border-blue-500/20 group-hover:scale-110 transition-transform duration-300">
            <i class="fa-solid fa-clipboard-list"></i>
        </div>
    </div>

    <div class="bg-gray-900 border border-gray-800 p-4 rounded-2xl flex items-center justify-between shadow-xl relative overflow-hidden group hover:border-amber-500/40 transition-all duration-300">
        <div class="space-y-1 relative z-10">
            <span class="text-[10px] font-mono uppercase tracking-wider text-gray-400">Seguimiento</span>
            <h3 class="text-2xl font-black text-white tracking-tight">
                {{ $incidencias->where('estado', 'En Revisión')->count() }}
            </h3>
            <p class="text-[11px] text-amber-400 flex items-center gap-1 font-medium">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> En Proceso
            </p>
        </div>
        <div class="w-10 h-10 bg-amber-500/10 rounded-lg flex items-center justify-center text-amber-500 text-sm border border-amber-500/20 group-hover:scale-110 transition-transform duration-300">
            <i class="fa-solid fa-spinner fa-spin"></i>
        </div>
    </div>

    <div class="bg-gray-900 border border-gray-800 p-4 rounded-2xl flex items-center justify-between shadow-xl relative overflow-hidden group hover:border-emerald-500/40 transition-all duration-300">
        <div class="space-y-1 relative z-10">
            <span class="text-[10px] font-mono uppercase tracking-wider text-gray-400">Resolución</span>
            <h3 class="text-2xl font-black text-white tracking-tight">
                {{ $incidencias->where('estado', 'Resuelto')->count() }}
            </h3>
            <p class="text-[11px] text-emerald-400 flex items-center gap-1 font-medium">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span> Finalizados
            </p>
        </div>
        <div class="w-10 h-10 bg-emerald-500/10 rounded-lg flex items-center justify-center text-emerald-500 text-sm border border-emerald-500/20 group-hover:scale-110 transition-transform duration-300">
            <i class="fa-solid fa-circle-check"></i>
        </div>
    </div>

    <!--aca podemos poner la tarjeta de combustible en futuro-->

    <div class="bg-gray-900 border border-gray-800 p-4 rounded-2xl flex items-center justify-between shadow-xl relative overflow-hidden group hover:border-emerald-500/40 transition-all duration-300">
        <div class="space-y-1 relative z-10">
            <span class="text-[10px] font-mono uppercase tracking-wider text-gray-400">Monitoreo Live</span>
            <h3 class="text-2xl font-black text-white tracking-tight">
                <span class="text-emerald-400">Activo</span>
            </h3>
            <p class="text-[11px] text-gray-400 font-medium">Estado del Sistema</p>
        </div>
        <div class="w-10 h-10 bg-emerald-500/10 rounded-lg flex items-center justify-center text-emerald-500 text-sm border border-emerald-500/20 group-hover:scale-110 transition-transform duration-300">
            <i class="fa-solid fa-square-poll-vertical"></i>
        </div>
    </div>

</div>