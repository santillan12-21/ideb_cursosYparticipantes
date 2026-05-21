<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        // Encontrar el usuario por su ID
        $user = User::findOrFail($id);

        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$id}",
            'puesto' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'edad' => 'required|integer|min:18',
            'password' => 'nullable|min:8|confirmed', // La contraseña es opcional
        ], [
            'edad.min' => 'La edad mínima permitida es de 18 años.',
        ]);

        // Actualizar los campos básicos
        $user->name = $request->name;
        $user->apellido = $request->apellido;
        $user->email = $request->email;
        $user->puesto = $request->puesto;
        $user->telefono = $request->telefono;
        $user->edad = $request->edad;

        // Si se proporciona una nueva contraseña, actualizarla y almacenarla en texto plano
        if ($request->filled('password')) {
            $plainPassword = $request->password; // Contraseña en texto plano
            $user->password = Hash::make($plainPassword); // Contraseña hasheada
            $user->plain_password = $plainPassword; // Almacenar la contraseña en texto plano
        }

        // Guardar los cambios en la base de datos
        $user->save();

        // Redirigir con un mensaje de éxito
        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'telefono' => 'required|string|max:15',
            'edad' => 'required|integer|min:18|max:90',
            'password' => 'required|string|min:8|confirmed',
            'puesto' => 'required|string|max:255'
        ], [
            'edad.min' => 'La edad mínima permitida es de 18 años.',
            'edad.max' => 'La edad máxima permitida es de 90 años.',
        ]);

        User::create([
            'name' => $request->name,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'edad' => $request->edad,
            'password' => Hash::make($request->password),
            'plain_password' => $request->password, // Guardar contraseña en texto plano
            'puesto' => $request->puesto
        ]);

        return redirect('/users')->with('success', 'Usuario creado exitosamente');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('users.profile', compact('user'));
    }

    public function showPassword(Request $request, $id)
    {
        // Obtener el usuario autenticado
        $admin = Auth::user();

        // Verificar que el usuario autenticado sea un administrador o programador
        if (!in_array($admin->puesto, ['Administrador', 'Programador'])) {
            return response()->json(['error' => 'Acceso denegado. Solo los administradores y programadores pueden realizar esta acción.'], 403);
        }

        // Validar la contraseña del administrador/programador
        $request->validate([
            'admin_password' => 'required|string',
        ]);

        // Verificar si la contraseña ingresada es correcta
        if (!Hash::check($request->admin_password, $admin->password)) {
            return response()->json(['error' => 'Tu contraseña es incorrecta.'], 401);
        }

        // Obtener el usuario cuya contraseña se quiere ver
        $user = User::findOrFail($id);

        // Devolver la contraseña en texto plano (si existe) o el hash (si no hay plain_password)
        $plainPassword = $user->plain_password ?? 'No disponible';
        return response()->json(['password' => $plainPassword]);
    }

}
