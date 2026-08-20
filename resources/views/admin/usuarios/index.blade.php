@extends('layouts.app')

@section('contenido')
<div class="w-full min-h-full">
    <div class="max-w-7xl mx-auto p-4 md:p-6">

        <!-- Encabezado -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6">
            <div>
                <h1 class="text-xl font-bold text-white tracking-wide flex items-center gap-2">
                    <i class="fa-solid fa-users-gear text-red-500"></i> Control de Usuarios del Sistema
                </h1>
                <p class="text-xs text-gray-400 mt-0.5">Gestión de credenciales, accesos y roles asignados al portal corporativo</p>
            </div>

            <a href="{{ route('gestion-usuarios.create') }}" 
               class="px-4 py-2.5 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition shadow-lg shadow-red-600/20 flex items-center gap-2 self-start md:self-auto cursor-pointer">
                <i class="fa-solid fa-user-plus"></i> Nuevo Usuario
            </a>
        </div>

        <!-- Mensajes de Notificación -->
        @if(session('exito'))
            <div class="bg-emerald-950/80 border border-emerald-500/50 text-emerald-300 p-4 rounded-xl text-xs flex items-center gap-2 mb-6">
                <i class="fa-solid fa-circle-check text-emerald-400 text-sm"></i> {{ session('exito') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-950/80 border border-red-500/50 text-red-300 p-4 rounded-xl text-xs mb-6">
                <i class="fa-solid fa-triangle-exclamation mr-1"></i> {{ $errors->first() }}
            </div>
        @endif

        <!-- Tabla de Usuarios -->
        <div class="bg-gray-900 border border-gray-800 rounded-2xl overflow-hidden shadow-2xl">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse text-sm">
                    <thead>
                        <tr class="bg-gray-950/80 text-gray-400 border-b border-gray-800 text-[11px] uppercase font-mono tracking-wider">
                            <th class="p-4">Usuario</th>
                            <th class="p-4">Correo Electrónico</th>
                            <th class="p-4">Rol / Permiso</th>
                            <th class="p-4">Fecha Registro</th>
                            <th class="p-4 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/60 text-gray-300">
                        @forelse($usuarios as $user)
                            <tr class="hover:bg-gray-800/40 transition">
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-gray-800 border border-gray-700 flex items-center justify-center font-bold text-white text-xs">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                        <div>
                                            <span class="font-bold text-white block text-sm">{{ $user->name }}</span>
                                            <span class="text-[10px] text-gray-500 font-mono">ID: #00{{ $user->id }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="p-4 font-mono text-xs text-gray-300">
                                    {{ $user->email }}
                                </td>

                                <td class="p-4">
                                    @php
                                        $roleColor = 'bg-gray-800 text-gray-400 border-gray-700';
                                        if($user->role === 'admin') {
                                            $roleColor = 'bg-red-950/80 text-red-400 border-red-800';
                                        } elseif($user->role === 'coordinador') {
                                            $roleColor = 'bg-amber-950/80 text-amber-400 border-amber-800';
                                        } elseif($user->role === 'gestor') {
                                            $roleColor = 'bg-emerald-950/80 text-emerald-400 border-emerald-800';
                                        }
                                    @endphp
                                    <span class="px-2.5 py-1 rounded text-[10px] font-mono font-bold uppercase border {{ $roleColor }}">
                                        {{ $user->role ?? 'sin rol' }}
                                    </span>
                                </td>

                                <td class="p-4 text-xs text-gray-400 font-mono">
                                    {{ $user->created_at ? $user->created_at->format('d/m/Y H:i') : 'N/A' }}
                                </td>

                                <td class="p-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" onclick="abrirModalEditar({{ json_encode($user) }})"
                                                class="p-2 bg-gray-800 hover:bg-gray-700 border border-gray-700 hover:border-blue-500 text-gray-300 hover:text-white rounded-lg text-xs transition cursor-pointer">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>

                                        @if(auth()->id() !== $user->id)
                                            <button type="button" onclick="abrirModalEliminar({{ $user->id }}, '{{ $user->name }}')"
                                                    class="p-2 bg-gray-800 hover:bg-red-950/80 border border-gray-700 hover:border-red-500 text-gray-300 hover:text-red-400 rounded-lg text-xs transition cursor-pointer">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-8 text-center text-gray-500">
                                    <i class="fa-solid fa-users-slash text-3xl mb-2 text-gray-600 block"></i>
                                    No hay usuarios registrados en el sistema.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($usuarios->hasPages())
                <div class="p-4 border-t border-gray-800">
                    {{ $usuarios->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- MODAL PARA EDITAR USUARIO -->
    <div id="modalEditar" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-950/80 backdrop-blur-sm p-4">
        <div class="bg-gray-900 border border-gray-800 rounded-2xl w-full max-w-md p-6 shadow-2xl relative mx-auto">
            <div class="flex justify-between items-center pb-4 border-b border-gray-800 mb-4">
                <h3 class="text-base font-bold text-white flex items-center gap-2">
                    <i class="fa-solid fa-user-pen text-red-500"></i> Editar Usuario
                </h3>
                <button onclick="cerrarModalEditar()" class="text-gray-400 hover:text-white cursor-pointer">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form id="formEditar" method="POST" action="" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-[10px] font-mono uppercase tracking-wider text-gray-400 mb-1">Nombre Completo</label>
                    <input type="text" id="edit_name" name="name" required class="w-full bg-gray-950 border border-gray-800 focus:border-red-500 text-white text-sm rounded-xl px-3 py-2 outline-none">
                </div>

                <div>
                    <label class="block text-[10px] font-mono uppercase tracking-wider text-gray-400 mb-1">Correo Electrónico</label>
                    <input type="email" id="edit_email" name="email" required class="w-full bg-gray-950 border border-gray-800 focus:border-red-500 text-white text-sm rounded-xl px-3 py-2 outline-none">
                </div>

                <div>
                    <label class="block text-[10px] font-mono uppercase tracking-wider text-gray-400 mb-1">Rol / Acceso</label>
                    <select id="edit_role" name="role" required class="w-full bg-gray-950 border border-gray-800 focus:border-red-500 text-white text-sm rounded-xl px-3 py-2 outline-none">
                        <option value="gestor">GESTOR</option>
                        <option value="coordinador">COORDINADOR</option>
                        <option value="admin">ADMINISTRADOR</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-mono uppercase tracking-wider text-gray-400 mb-1">Nueva Contraseña (Opcional)</label>
                    <input type="password" name="password" placeholder="Dejar en blanco para no cambiar" class="w-full bg-gray-950 border border-gray-800 focus:border-red-500 text-white text-sm rounded-xl px-3 py-2 outline-none placeholder:text-gray-600">
                </div>

                <div class="flex justify-end gap-3 pt-3 border-t border-gray-800">
                    <button type="button" onclick="cerrarModalEditar()" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs font-bold rounded-xl transition cursor-pointer">
                        Cancelar
                    </button>
                    <button type="submit" class="px-5 py-2 bg-red-600 hover:bg-red-700 text-white text-xs font-bold rounded-xl transition shadow-lg shadow-red-600/20 cursor-pointer">
                        Actualizar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL CONFIRMAR ELIMINACIÓN -->
    <div id="modalEliminar" class="fixed inset-0 z-50 hidden flex items-center justify-center bg-gray-950/80 backdrop-blur-sm p-4">
        <div class="bg-gray-900 border border-gray-800 rounded-2xl w-full max-w-md p-6 shadow-2xl relative mx-auto text-center space-y-4">
            
            <div class="w-12 h-12 rounded-full bg-red-500/10 border border-red-500/20 text-red-500 flex items-center justify-center mx-auto text-xl">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            
            <div>
                <h3 class="text-lg font-bold text-white">¿Eliminar Usuario?</h3>
                <p class="text-xs text-gray-400 mt-1">
                    Esta acción revocará de inmediato los accesos del usuario <span id="delete_userName" class="text-white font-bold"></span> al sistema.
                </p>
            </div>

            <form id="formEliminar" method="POST" action="" class="flex items-center justify-center gap-3 pt-2">
                @csrf
                @method('DELETE')
                <button type="button" onclick="cerrarModalEliminar()" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-gray-300 text-xs font-medium rounded-xl transition cursor-pointer">
                    Cancelar
                </button>
                <button type="submit" class="px-5 py-2 bg-red-600 hover:bg-red-500 text-white text-xs font-medium rounded-xl shadow-lg shadow-red-950/50 transition cursor-pointer">
                    Sí, Eliminar
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function abrirModalEditar(user) {
        document.getElementById('edit_name').value = user.name;
        document.getElementById('edit_email').value = user.email;
        document.getElementById('edit_role').value = user.role || 'gestor';
        document.getElementById('formEditar').action = `/gestion-usuarios/${user.id}`;
        document.getElementById('modalEditar').classList.remove('hidden');
    }

    function cerrarModalEditar() {
        document.getElementById('modalEditar').classList.add('hidden');
    }

    function abrirModalEliminar(id, name) {
        document.getElementById('delete_userName').innerText = name;
        document.getElementById('formEliminar').action = `/gestion-usuarios/${id}`;
        document.getElementById('modalEliminar').classList.remove('hidden');
    }

    function cerrarModalEliminar() {
        document.getElementById('modalEliminar').classList.add('hidden');
    }
</script>
@endsection