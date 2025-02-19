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
    /**
     * Verifica si una ruta existe en el sistema.
     */
    public function verificarRuta(Request $request)
    {
        try {
            $ruta = $request->query('ruta');
            $existe = File::exists($ruta);

            return response()->json([
                'exists' => $existe,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'exists' => false,
                'message' => 'Error al verificar la ruta: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function abrirCarpeta(Request $request)
    {
        try {
            // Obtener la ruta desde la solicitud
            $ruta = $request->input('ruta');

            // Validar que la ruta no esté vacía
            if (empty($ruta)) {
                return response()->json([
                    'success' => false,
                    'message' => 'La ruta no puede estar vacía.'
                ], 400);
            }

            // Construir el comando para ejecutar el script Python
            $comando = escapeshellcmd("python \"C:/xampp/htdocs/Proyecto IDB/CursosyParticipantes/storage/app/public/abrir_carpeta.py\" \"$ruta\"");

            // Ejecutar el comando
            exec($comando, $output, $return_var);

            // Verificar si el comando se ejecutó correctamente
            if ($return_var === 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Carpeta abierta exitosamente.',
                    'output' => $output
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al abrir la carpeta.',
                    'output' => $output,
                    'return_var' => $return_var
                ], 500);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al procesar la solicitud: ' . $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function obtenerUltimaRuta()
    {
        try {
            // Verificar si el archivo existe
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
                    'data' => $ultimaRuta['rutaCompleta']
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

    public function obtenerTodasLasRutas()
    {
        try {
            // Verificar si el archivo existe
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

                // Extraer solo las rutas completas
                $rutas = array_map(function ($item) {
                    return [
                        'nombreCarpeta' => $item['nombreCarpeta'],
                        'rutaCompleta' => $item['rutaCompleta']
                    ];
                }, $config);

                return response()->json([
                    'success' => true,
                    'data' => $rutas
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'No hay configuración guardada.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener las rutas: ' . $e->getMessage()
            ], 500);
        }
    }
}
