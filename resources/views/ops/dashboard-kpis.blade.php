<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    
    <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl flex items-center justify-between shadow-xl relative overflow-hidden group hover:border-blue-500/40 transition-all duration-300">
        <div class="space-y-2 relative z-10">
            <span class="text-xs font-mono uppercase tracking-wider text-gray-400">Control Operativo</span>
            <h3 class="text-3xl font-black text-white tracking-tight">
                {{ $incidencias->where('tipo', 'checklist')->count() ?? 0 }}
            </h3>
            <p class="text-xs text-blue-400 flex items-center gap-1 font-medium">
                <span class="w-1.5 h-1.5 rounded-full bg-blue-500 animate-pulse"></span> Checklist Completados
            </p>
        </div>
        <div class="w-14 h-14 bg-blue-500/10 rounded-xl flex items-center justify-center text-blue-500 text-xl border border-blue-500/20 group-hover:scale-110 transition-transform duration-300 shadow-[0_0_15px_rgba(59,130,246,0.1)]">
            <i class="fa-solid fa-clipboard-check"></i>
        </div>
    </div>

    <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl flex items-center justify-between shadow-xl relative overflow-hidden group hover:border-amber-500/40 transition-all duration-300">
        <div class="space-y-2 relative z-10">
            <span class="text-xs font-mono uppercase tracking-wider text-gray-400">Eficiencia Energética</span>
            <h3 class="text-3xl font-black text-white tracking-tight">
                {{ $incidencias->where('tipo', 'combustible')->count() ?? 0 }}
            </h3>
            <p class="text-xs text-amber-400 flex items-center gap-1 font-medium">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span> Alertas de Combustible
            </p>
        </div>
        <div class="w-14 h-14 bg-amber-500/10 rounded-xl flex items-center justify-center text-amber-500 text-xl border border-amber-500/20 group-hover:scale-110 transition-transform duration-300 shadow-[0_0_15px_rgba(245,158,11,0.1)]">
            <i class="fa-solid fa-gas-pump"></i>
        </div>
    </div>

    <div class="bg-gray-900 border border-gray-800 p-6 rounded-2xl flex items-center justify-between shadow-xl relative overflow-hidden group hover:border-emerald-500/40 transition-all duration-300">
        <div class="space-y-2 relative z-10">
            <span class="text-xs font-mono uppercase tracking-wider text-gray-400">Monitoreo Live</span>
            <h3 class="text-3xl font-black text-white tracking-tight flex items-center gap-2">
                <span class="text-emerald-400">Activo</span>
            </h3>
            <p class="text-xs text-gray-400 font-medium">Estado del Sistema</p>
        </div>
        <div class="w-14 h-14 bg-emerald-500/10 rounded-xl flex items-center justify-center text-emerald-500 text-xl border border-emerald-500/20 group-hover:scale-110 transition-transform duration-300 shadow-[0_0_15px_rgba(16,185,129,0.1)]">
            <i class="fa-solid fa-square-poll-vertical"></i>
        </div>
    </div>

</div>