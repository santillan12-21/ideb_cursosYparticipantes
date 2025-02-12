<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;

class LoginController extends Controller
{

    use AuthenticatesUsers;

    // Sobrescribir el método para enviar una respuesta de error personalizada
    protected function sendFailedLoginResponse(Request $request)
    {
        // Verificar si el correo existe en la base de datos
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            // Si el correo no existe
            return redirect()->back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['email' => 'El correo electrónico no está registrado.']);
        } else {
            // Si el correo existe pero la contraseña es incorrecta
            return redirect()->back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors(['password' => 'La contraseña es incorrecta.']);
        }
    }
    public function login(Request $request)
    {
        // Validar los campos del formulario
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Verificar si el correo existe en la base de datos
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            // Si el correo no existe
            return back()->withErrors([
                'email' => 'El correo electrónico no está registrado.',
            ])->withInput($request->only('email'));
        }

        // Intentar autenticar al usuario
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('Inicio');
        }

        // Si la contraseña es incorrecta
        return back()->withErrors([
            'password' => 'La contraseña es incorrecta.',
        ])->withInput($request->only('email'));
    }

}
