<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        
        return view('users.index', compact('users'));
    }

    public function create()
{
    // Obtener todos los roles disponibles
    $roles = Role::pluck('name', 'id');
    
    // Definir los roles permitidos para crear usuarios según el rol del usuario autenticado
    $allowedRoles = [];
    
    // Verificar el rol del usuario autenticado
    if (Auth::user()->roles->contains('name', 'admin')) {
        // Si el usuario es un administrador, permitir todos los roles
        $allowedRoles = $roles->all();
    } elseif (Auth::user()->roles->contains('name', 'supervisor')) {
        // Si el usuario es un supervisor, permitir solo el rol de usuario
        $allowedRoles = $roles->filter(function ($role) {
            return $role === 'usuario';
        })->all();
    } elseif (Auth::user()->roles->contains('name', 'supervisor-productos')) {
        // Si el usuario es un supervisor, permitir solo el rol de usuario
        $allowedRoles = $roles->filter(function ($role) {
            return $role === 'usuario-productos';
        })->all();
    }
    
    // Pasar los roles permitidos a la vista solo si hay roles permitidos
    return view('users.create', ['allowedRoles' => $allowedRoles]);
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required', // Agregar validación para el rol
        ]);

        // Crear un nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'legajo' => $request->legajo, // Guardar el legajo del usuario
        ]);

        // Obtener el rol según el ID proporcionado en el formulario
        $roleId = $request->role;
        $role = Role::findOrFail($roleId);

        // Asignar el rol al usuario
        $user->assignRole($role);

        // Recuperar los permisos asociados al rol y asignarlos al usuario
        $permissions = $role->permissions;
        
        $user->givePermissionTo($permissions);

        // Redirigir al usuario a la página de índice de usuarios
        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }

    public function edit($id)
{
    $this->authorize('editar-usuarios', User::class);
    // Buscar el usuario por su ID
    $user = User::findOrFail($id);
    
    // Retornar la vista de edición con los datos del usuario
    return view('users.edit', compact('user'));
}

    public function update(Request $request, User $user)
    {
        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8', // La contraseña es opcional
        ]);

        // Actualizar los datos del usuario
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        // Redirigir al usuario a la página de índice de usuarios
        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    try {
        // Buscar el usuario por su ID
        $user = User::findOrFail($id);
        
        // Eliminar al usuario
        $user->delete();

        // Eliminar los permisos asociados al usuario
        $user->permissions()->detach();

        // Redirigir al usuario a la página de índice de usuarios
        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
    } catch (\Exception $e) {
        // Log de cualquier error que ocurra
        Log::error('Error al eliminar el usuario: ' . $e->getMessage());
        
        // Redirigir de nuevo a la página de índice de usuarios con un mensaje de error
        return redirect()->route('users.index')->with('error', 'Error al eliminar el usuario.');
    }
}
}
