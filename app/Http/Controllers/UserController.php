<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    // Listar usuarios registrados
    public function index()
    {
        // Obtener todos los usuarios paginados de 10 en 10
        $usuarios = User::orderBy('id', 'desc')->paginate(10);

        // Retornar la vista pasando los datos
        return view('admin.usuarios.index', compact('usuarios'));
    }

    // Formulario de nuevo usuario
    public function create()
    {
        return view('admin.usuarios.create');
    }

    // Guardar nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:admin,coordinador,gestor',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'El nombre es obligatorio.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Ingresa un correo electrónico válido.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
            'role.required' => 'Debes seleccionar un rol.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);

        return redirect()->route('gestion-usuarios.index')
            ->with('exito', 'Usuario creado exitosamente.');
    }

    // Actualizar usuario
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,coordinador,gestor',
            'password' => 'nullable|min:6',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('gestion-usuarios.index')
            ->with('exito', 'Usuario actualizado correctamente.');
    }

    // Eliminar usuario
    public function destroy($id)
    {
        // Evitar que un usuario se elimine a sí mismo
        if (auth()->id() == $id) {
            return redirect()->route('gestion-usuarios.index')
                ->withErrors('No puedes eliminar tu propia cuenta.');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('gestion-usuarios.index')
            ->with('exito', 'Usuario eliminado correctamente del sistema.');
    }

}