<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENOSA - Iniciar Sesión</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body class="bg-gray-950 text-gray-100 font-sans min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] bg-red-600/10 rounded-full blur-[120px] pointer-events-none"></div>
    <div class="absolute bottom-[-20%] right-[-10%] w-[500px] h-[500px] bg-gray-600/10 rounded-full blur-[120px] pointer-events-none"></div>

    <div class="w-full max-w-md bg-gray-900 border border-gray-800 rounded-2xl shadow-2xl p-8 z-10 relative">
        
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center bg-gray-800 p-4 rounded-full border border-gray-700/50 mb-3 shadow-inner">
                <i class="fa-solid fa-shield-halved text-3xl text-red-500"></i>
            </div>
            <h1 class="text-2xl font-extrabold tracking-tight text-white">Panel Operativo</h1>
            <p class="text-xs text-gray-400 mt-1 uppercase tracking-wider font-mono">Control de Incidencias RENOSA</p>
        </div>

        @if($errors->any())
            <div class="bg-red-950/50 border border-red-500/50 text-red-400 p-3 rounded-lg text-xs flex items-start gap-2 mb-4">
                <i class="fa-solid fa-circle-exclamation mt-0.5 shrink-0"></i>
                <span>{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ url('/login') }}" method="POST" class="space-y-5">
            @csrf
            
            <div>
                <label class="block text-xs font-semibold text-gray-400 uppercase mb-2 tracking-wider">Correo Electrónico</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-500">
                        <i class="fa-solid fa-envelope"></i>
                    </span>
                    <input type="email" name="email" required value="{{ old('email') }}" placeholder="usuario@renosa.com"
                        class="w-full bg-gray-950 border border-gray-800 rounded-xl pl-10 pr-4 py-3 text-sm text-gray-100 placeholder-gray-600 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition">
                </div>
            </div>

            <div>
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Contraseña</label>
                </div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-gray-500">
                        <i class="fa-solid fa-lock"></i>
                    </span>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="w-full bg-gray-950 border border-gray-800 rounded-xl pl-10 pr-4 py-3 text-sm text-gray-100 placeholder-gray-600 focus:outline-none focus:border-red-500 focus:ring-1 focus:ring-red-500 transition">
                </div>
            </div>

            <div class="flex items-center justify-between pt-1">
                <label class="flex items-center gap-2 cursor-pointer select-none">
                    <input type="checkbox" name="remember" class="w-4 h-4 rounded bg-gray-950 border-gray-800 text-red-600 focus:ring-0 focus:ring-offset-0 cursor-pointer accent-red-600">
                    <span class="text-xs text-gray-400">Recordar sesión</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 active:bg-red-800 text-white font-bold py-3 px-4 rounded-xl transition shadow-lg shadow-red-900/20 flex justify-center items-center gap-2 mt-2">
                <i class="fa-solid fa-right-to-bracket"></i> Acceder al Sistema
            </button>
        </form>

        <div class="mt-8 pt-4 border-t border-gray-800/60 text-center text-[10px] text-gray-500 font-mono tracking-wide">
            SISTEMA DE SEGURIDAD INTERNA © 2026
        </div>

    </div>
</body>
</html>