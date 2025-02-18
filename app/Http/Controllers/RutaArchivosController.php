<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class RutaArchivosController extends Controller
{
    private $configFile = 'config/ruta_archivos.json';

    public function guardar(Request $request)
    {
        $request->validate([
            'nombreCarpeta' => 'required|string',
            'rutaCarpeta' => 'required|string',
        ]);

        try {
            // Limpiar y normalizar la ruta
            $rutaCarpeta = rtrim($request->rutaCarpeta, '/\\');
            $nombreCarpeta = trim($request->nombreCarpeta);
            $rutaCompleta = $rutaCarpeta . DIRECTORY_SEPARATOR . $nombreCarpeta;

            // Verificar si la ruta base existe
            if (!File::exists($rutaCarpeta)) {
                return response()->json([
                    'success' => false,
                    'message' => 'La ruta base especificada no existe.'
                ], 400);
            }

            // Crear la carpeta si no existe
            if (!File::exists($rutaCompleta)) {
                File::makeDirectory($rutaCompleta, 0755, true);
            }

            // Guardar la configuración
            $config = [
                'nombreCarpeta' => $nombreCarpeta,
                'rutaCarpeta' => $rutaCarpeta,
                'rutaCompleta' => $rutaCompleta,
                'timestamp' => now()->toDateTimeString()
            ];

            // Asegurar que el directorio config existe
            if (!Storage::exists('config')) {
                Storage::makeDirectory('config');
            }

            // Guardar la configuración en el archivo JSON
            Storage::put($this->configFile, json_encode($config, JSON_PRETTY_PRINT));

            return response()->json([
                'success' => true,
                'message' => 'Carpeta creada y ruta guardada correctamente.',
                'data' => $config
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la solicitud: ' . $e->getMessage()
            ], 500);
        }
    }

    public function obtenerRuta()
    {
        try {
            if (Storage::exists($this->configFile)) {
                $config = json_decode(Storage::get($this->configFile), true);
                return response()->json([
                    'success' => true,
                    'data' => $config
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No hay configuración guardada.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener la configuración: ' . $e->getMessage()
            ], 500);
        }
    }
}
