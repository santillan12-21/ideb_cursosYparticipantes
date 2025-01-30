<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class ConfigController extends Controller
{
    public function index()
    {
        // Obtener configuraciones actuales
        $currentTimezone = config('app.timezone');
        $currentLanguage = config('app.locale');
        $currentCurrency = env('CURRENCY', 'MXN');
        $currentDbConnection = env('DB_CONNECTION', 'mysql');

        return view('configuraciones.index', compact(
            'currentTimezone',
            'currentLanguage',
            'currentCurrency',
            'currentDbConnection'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'timezone' => 'required|string',
            'language' => 'required|string',
            'currency' => 'required|string',
            'db_connection' => 'required|string',
        ]);

        // Guardar configuraciones en sesión
        Session::put('language', $request->input('language'));

        // Actualizar .env
        $this->updateEnv([
            'APP_TIMEZONE' => $request->input('timezone'),
            'APP_LOCALE' => $request->input('language'),
            'CURRENCY' => $request->input('currency'),
            'DB_CONNECTION' => $request->input('db_connection'),
        ]);

        return redirect()->route('configuraciones.index')
            ->with('success', 'Configuraciones actualizadas correctamente.');
    }

    private function updateEnv($data = [])
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);

        foreach ($data as $key => $value) {
            $str = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $str);
        }

        file_put_contents($envFile, $str);
    }
}
