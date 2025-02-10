<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email'); // Vista para solicitar el correo
    }

    public function sendResetLinkEmail(Request $request)
    {
        // Validar la solicitud
        $request->validate(['email' => 'required|email']);

        // Verificar si el usuario existe
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'No encontramos un usuario con esa dirección de correo.']);
        }

        // Generar un token de restablecimiento
        $token = Str::random(60);

        // Guardar el token en la base de datos
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => now(),
        ]);

        // Generar la URL de restablecimiento
        $url = url('password/reset', $token) . '?email=' . urlencode($request->email);

        // Enviar el correo
        Mail::send('auth.passwords.email_reset_link', [
            'url' => $url // Pasar la URL generada a la vista del correo
        ], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Restablecer Contraseña');
        });

        return back()->with('status', 'Se ha enviado un enlace de restablecimiento a tu correo.');
    }
}
