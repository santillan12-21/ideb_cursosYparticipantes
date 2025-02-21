<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

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


    public function exportCursos()
    {
        // Obtener los datos de la tabla "cursos"
        $cursos = DB::table('cursos')->get();

        // Crear una respuesta de flujo para descargar el archivo SQL
        return response()->streamDownload(function () use ($cursos) {
            $output = fopen('php://output', 'w');

            // Escribir el encabezado del archivo SQL
            fwrite($output, "-- Exportación de la tabla 'cursos'\n");
            fwrite($output, "-- Fecha: " . now() . "\n\n");

            // Generar los comandos INSERT
            foreach ($cursos as $curso) {
                $columns = implode("`, `", array_keys((array) $curso));
                $values = implode("', '", array_map(fn($value) => addslashes($value), (array) $curso));
                fwrite($output, "INSERT INTO `cursos` (`{$columns}`) VALUES ('{$values}');\n");
            }

            fclose($output);
        }, 'export_cursos.sql');
    }

    public function exportParticipantes()
    {
        // Obtener los datos de la tabla "participantes"
        $participantes = DB::table('participantes')->get();

        // Crear una respuesta de flujo para descargar el archivo SQL
        return response()->streamDownload(function () use ($participantes) {
            $output = fopen('php://output', 'w');

            // Escribir el encabezado del archivo SQL
            fwrite($output, "-- Exportación de la tabla 'participantes'\n");
            fwrite($output, "-- Fecha: " . now() . "\n\n");

            // Generar los comandos INSERT
            foreach ($participantes as $participante) {
                $columns = implode("`, `", array_keys((array) $participante));
                $values = implode("', '", array_map(fn($value) => addslashes($value), (array) $participante));
                fwrite($output, "INSERT INTO `participantes` (`{$columns}`) VALUES ('{$values}');\n");
            }

            fclose($output);
        }, 'export_participantes.sql');
    }

    public function openInVsCode()
    {
        // Obtener la ruta base del proyecto
        $projectPath = base_path();

        // Comando para abrir VS Code con la carpeta del proyecto
        $command = "code " . escapeshellarg($projectPath);

        // Ejecutar el comando en el sistema operativo
        try {
            exec($command);
            return redirect()->back()->with('success', 'Visual Studio Code se ha abierto con la carpeta del proyecto.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'No se pudo abrir Visual Studio Code: ' . $e->getMessage());
        }
    }
}
