@extends('layouts.app')

@section('contenido')
<style>
    /* Ocultar el ojo nativo de Microsoft Edge con máxima prioridad */
    input[type="password"]::-ms-reveal,
    input[type="password"]::-ms-clear,
    ::-ms-reveal {
        display: none !important;
        width: 0 !important;
        height: 0 !important;
    }

    /* Ocultar iconos de autocompletado nativos de Chrome/Safari */
    input::-webkit-contacts-auto-fill-button,
    input::-webkit-credentials-auto-fill-button {
        visibility: hidden !important;
        display: none !important;
        pointer-events: none !important;
    }

    /* Eliminar el fondo azul/blanco por defecto del autocompletado */
    input:-webkit-autofill,
    input:-webkit-autofill:hover, 
    input:-webkit-autofill:focus {
        -webkit-text-fill-color: #ffffff !important;
        -webkit-box-shadow: 0 0 0px 1000px #030712 inset !important;
        transition: background-color 5000s ease-in-out 0s;
    }
</style>

<div class="max-w-lg w-full py-4">

    <!-- Encabezado -->
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-white tracking-wide flex items-center gap-2">
                <i class="fa-solid fa-user-plus text-red-500"></i> Registrar Usuario
            </h1>
            <p class="text-xs text-gray-400 mt-0.5">Asigna credenciales y el nivel de acceso</p>
        </div>
        
        <a href="{{ route('gestion-usuarios.index') }}" 
           class="px-3 py-2 bg-gray-800 hover:bg-gray-700 border border-gray-700 text-gray-300 text-xs font-medium rounded-xl transition flex items-center gap-2">
            <i class="fa-solid fa-arrow-left"></i> Volver
        </a>
    </div>

    <!-- Alertas de error -->
    @if($errors->any())
        <div class="bg-red-950/80 border border-red-500/50 text-red-300 p-4 rounded-xl text-xs mb-6">
            <i class="fa-solid fa-triangle-exclamation mr-1"></i> {{ $errors->first() }}
        </div>
    @endif

    <!-- Formulario -->
    <div class="bg-gray-900 border border-gray-800 rounded-2xl p-6 shadow-2xl">
        <form action="{{ route('gestion-usuarios.store') }}" method="POST" autocomplete="off" class="space-y-4">
            @csrf

            <div>
                <label class="block text-[10px] font-mono uppercase tracking-wider text-gray-400 mb-1">Nombre Completo</label>
                <input type="text" name="name" value="{{ old('name') }}" required 
                       placeholder="Ej. Juan Pérez" 
                       class="w-full bg-gray-950 border border-gray-800 focus:border-red-500 text-white text-sm rounded-xl px-3 py-2.5 outline-none placeholder:text-gray-600">
            </div>

            <div>
                <label class="block text-[10px] font-mono uppercase tracking-wider text-gray-400 mb-1">Correo Electrónico</label>
                <input type="email" name="email" value="{{ old('email') }}" required 
                       placeholder="usuario@renosa.com" 
                       class="w-full bg-gray-950 border border-gray-800 focus:border-red-500 text-white text-sm rounded-xl px-3 py-2.5 outline-none placeholder:text-gray-600">
            </div>

            <div>
                <label class="block text-[10px] font-mono uppercase tracking-wider text-gray-400 mb-1">Rol / Permiso</label>
                <select name="role" required class="w-full bg-gray-950 border border-gray-800 focus:border-red-500 text-white text-sm rounded-xl px-3 py-2.5 outline-none">
                    <option value="gestor" {{ old('role') === 'gestor' ? 'selected' : '' }}>GESTOR</option>
                    <option value="coordinador" {{ old('role') === 'coordinador' ? 'selected' : '' }}>COORDINADOR</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>ADMINISTRADOR</option>
                </select>
            </div>

            <div>
                <label class="block text-[10px] font-mono uppercase tracking-wider text-gray-400 mb-1">Contraseña</label>
                <div class="relative w-full">
                    <input type="password" id="password" name="password" required autocomplete="new-password"
                           placeholder="••••••••" 
                           class="w-full bg-gray-950 border border-gray-800 focus:border-red-500 text-white text-sm rounded-xl pl-3 pr-12 py-2.5 outline-none placeholder:text-gray-600">
                    <button type="button" onclick="togglePasswordVisibility()" 
                            class="absolute inset-y-0 right-4 flex items-center text-gray-400 hover:text-white transition focus:outline-none z-10 cursor-pointer">
                        <i id="toggleIcon" class="fa-solid fa-eye text-sm"></i>
                    </button>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-800">
                <a href="{{ route('gestion-usuarios.index') }}" 
                   class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs font-bold rounded-xl transition cursor-pointer">
                    Cancelar
                </a>
                <button type="submit" 
                        class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition shadow-lg shadow-red-600/20 cursor-pointer">
                    Guardar Usuario
                </button>
            </div>
        </form>
    </div>

</div>

<script>
    function togglePasswordVisibility() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
</script>
@endsection