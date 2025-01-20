<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); // Obtiene todos los usuarios de la base de datos
        return view('users.index', compact('users')); // Retorna la vista con los usuarios
    }


    public function create()
    {
        return view('users.create');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id); // Busca al usuario o lanza un error si no existe
        return view('users.edit', compact('user')); // Retorna la vista con los datos del usuario
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id); // Busca al usuario o lanza un error si no existe

        // Validar los datos del formulario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$id}",
            'puesto' => 'required|string|max:255',
            'password' => 'nullable|min:8', // Contraseña opcional
        ]);

        // Actualizar los datos del usuario
        $user->name = $request->name;
        $user->email = $request->email;
        $user->puesto = $request->puesto;

        // Si se proporcionó una nueva contraseña, actualizarla
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save(); // Guardar los cambios en la base de datos

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente');
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'puesto' => 'required'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'puesto' => $request->puesto
        ]);


        return redirect('/Inicio')->with('success', 'Usuario creado exitosamente');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente');
    }


}
