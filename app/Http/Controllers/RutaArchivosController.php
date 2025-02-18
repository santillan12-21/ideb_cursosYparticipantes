<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class RutaArchivosController extends Controller
{
    private $configFile = 'config/ruta_archivos.json';

    /**
     * Guarda una nueva ruta en el archivo JSON.
     */
    public function guardar(Request $request)
{
    try {
        // Validar la solicitud
        $request->validate([
            'nombreCarpeta' => 'required|string',
            'rutaCarpeta' => 'required|string',
        ]);

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

        // Leer las rutas existentes o inicializar un array vacío
        $rutasExistentes = [];
        if (Storage::exists('config/ruta_archivos.json')) {
            $contenido = Storage::get('config/ruta_archivos.json');
            $rutasExistentes = json_decode($contenido, true);

            // Verificar si el contenido es un array
            if (!is_array($rutasExistentes)) {
                $rutasExistentes = [];
            }
        }

        // Agregar la nueva ruta
        $nuevaRuta = [
            'nombreCarpeta' => $nombreCarpeta,
            'rutaCarpeta' => $rutaCarpeta,
            'rutaCompleta' => $rutaCompleta,
            'timestamp' => now()->toDateTimeString()
        ];

        $rutasExistentes[] = $nuevaRuta;

        // Guardar el archivo JSON actualizado
        Storage::put('config/ruta_archivos.json', json_encode($rutasExistentes, JSON_PRETTY_PRINT));

        return response()->json([
            'success' => true,
            'message' => 'Carpeta creada y ruta guardada correctamente.',
            'data' => $nuevaRuta
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error al procesar la solicitud: ' . $e->getMessage()
        ], 500);
    }
}

    /**
     * Obtiene todas las rutas guardadas en el archivo JSON.
     */
    public function obtenerRuta()
{
    try {
        if (Storage::exists('config/ruta_archivos.json')) {
            $contenido = Storage::get('config/ruta_archivos.json');
            $config = json_decode($contenido, true);

            // Verificar si el contenido es un array
            if (!is_array($config)) {
                return response()->json([
                    'success' => false,
                    'message' => 'El archivo de configuración no tiene el formato correcto.'
                ], 400);
            }

            // Obtener la última ruta registrada
            $ultimaRuta = end($config);

            return response()->json([
                'success' => true,
                'data' => $ultimaRuta
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
