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
        $user = User::findOrFail($id);


        $request->validate([
            'name' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => "required|email|unique:users,email,{$id}",
            'puesto' => 'required|string|max:255',
            'telefono' => 'required|string|max:15',
            'edad' => 'required|integer|min:0',
            'password' => 'nullable|min:8|confirmed',
        ]);


        $user->name = $request->name;
        $user->apellido = $request->apellido;
        $user->email = $request->email;
        $user->puesto = $request->puesto;
        $user->telefono = $request->telefono;
        $user->edad = $request->edad;


        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'telefono' => 'required|string|max:15',
            'edad' => 'required|integer|min:0',
            'password' => 'required|string|min:8|confirmed',
            'puesto' => 'required|string|max:255'
        ]);

        User::create([
            'name' => $request->name,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'edad' => $request->edad,
            'password' => Hash::make($request->password),
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
}
