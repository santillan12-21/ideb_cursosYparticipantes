<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cursos;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CursosExport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cursos = Cursos::orderBy('created_at', 'asc')->paginate(10);
        return view('cursos.index', compact('cursos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    // Buscar el curso por ID
    $curso = Cursos::findOrFail($id);
    return view('cursos.show', compact('curso'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cursos $curso)
    {
        return view('cursos.edit', compact('curso'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $curso = Cursos::findOrFail($id);
            $curso->delete();

            return redirect()->route('cursos.index')
                ->with('success', 'Curso eliminado exitosamente');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Error al eliminar el curso: ' . $e->getMessage());
        }
    }

    // Mostrar el formulario del Paso 1
    public function crearPaso1()
    {
        return view('cursos.paso1');
    }

    // Guardar los datos del Paso 1 y redirigir al Paso 2
    public function guardarPaso1(Request $request)
    {
        $validated = $request->validate([
            'Nomenclatura' => 'required|string|max:255',
            'NombredelCurso' => 'required|string|max:255',
            'DescripciondeCurso' => 'required|string',
            'CostodelCurso' => 'required|numeric',
            'InstructorResponsable' => 'required|string|max:255',
            'FechadeInicio' => 'required|date',
            'FechadeTermino' => 'required|date|after_or_equal:FechadeInicio',
            'Duracioncurso' => 'required|string|max:255',
        ]);

        // Guardar los datos del Paso 1 en sesión
        session(['cursos_paso1' => $validated]);

        return redirect()->route('curso.paso2');
    }

    // Mostrar el formulario del Paso 2
    public function mostrarPaso2()
    {
        return view('cursos.paso2');
    }

    // Guardar los datos del Paso 2 y redirigir al Paso 3
    public function guardarPaso2(Request $request)
    {
        $validated = $request->validate([
            'Virtual' => 'required|in:Si,No',
            'Presencial' => 'required|in:Si,No',
            'Mixto' => 'required|in:Si,No',
        ]);

        // Guardar los datos del Paso 2 en sesión
        session(['cursos_paso2' => $validated]);

        return redirect()->route('curso.paso3');
    }

    // Mostrar el formulario del Paso 3
    public function mostrarPaso3()
    {
        return view('cursos.paso3');
    }

    // Guardar los datos del Paso 3 y redirigir al Paso 4
    public function guardarPaso3(Request $request)
{
    try {
        // Validar los datos del formulario
        $validated = $request->validate([
            'SinFecha' => 'required|string|max:255',
            'DriveSinFecha' => 'nullable|string|max:255',
            'Facebook' => 'required|string|max:255',
            'DriveFacebook' => 'nullable|string|max:255',
            'Linkedin' => 'required|string|max:255',
            'DriveLinkedin' => 'nullable|string|max:255',
            'Instagram' => 'required|string|max:255',
            'DriveInstagram' => 'nullable|string|max:255',
        ]);

        // Obtener la configuración de ruta
        $configJson = Storage::get('config/ruta_archivos.json');
        $config = json_decode($configJson, true);

        if (!$config) {
            return redirect()->back()->with('error', 'Error: No se ha configurado la ruta de archivos.');
        }

        $rutaBase = $config['rutaCompleta'];
        $rutasArchivos = [];

        // Verificar y crear carpetas si no existen
        $carpetas = ['SinFecha', 'Facebook', 'LinkedIn', 'Instagram'];
        foreach ($carpetas as $carpeta) {
            $rutaCarpeta = $rutaBase . DIRECTORY_SEPARATOR . $carpeta;
            if (!File::exists($rutaCarpeta)) {
                File::makeDirectory($rutaCarpeta, 0755, true);
            }
        }

        // Guardar archivos si fueron subidos
        if ($request->hasFile('SinFechaLocal')) {
            $archivo = $request->file('SinFechaLocal');
            $nombreArchivo = time() . '_sinfecha_' . $archivo->getClientOriginalName();
            $archivo->move($rutaBase . DIRECTORY_SEPARATOR . 'SinFecha', $nombreArchivo);
            $rutasArchivos['SinFechaLocal'] = 'SinFecha/' . $nombreArchivo;
        }

        if ($request->hasFile('FacebookLocal')) {
            $archivo = $request->file('FacebookLocal');
            $nombreArchivo = time() . '_facebook_' . $archivo->getClientOriginalName();
            $archivo->move($rutaBase . DIRECTORY_SEPARATOR . 'Facebook', $nombreArchivo);
            $rutasArchivos['FacebookLocal'] = 'Facebook/' . $nombreArchivo;
        }

        if ($request->hasFile('LinkedInLocal')) {
            $archivo = $request->file('LinkedInLocal');
            $nombreArchivo = time() . '_linkedin_' . $archivo->getClientOriginalName();
            $archivo->move($rutaBase . DIRECTORY_SEPARATOR . 'LinkedIn', $nombreArchivo);
            $rutasArchivos['LinkedInLocal'] = 'LinkedIn/' . $nombreArchivo;
        }

        if ($request->hasFile('InstagramLocal')) {
            $archivo = $request->file('InstagramLocal');
            $nombreArchivo = time() . '_instagram_' . $archivo->getClientOriginalName();
            $archivo->move($rutaBase . DIRECTORY_SEPARATOR . 'Instagram', $nombreArchivo);
            $rutasArchivos['InstagramLocal'] = 'Instagram/' . $nombreArchivo;
        }

        // Guardar los datos en la sesión
        session(['cursos_paso3' => array_merge($validated, $rutasArchivos)]);

        // Redirigir al siguiente paso
        return redirect()->route('curso.paso4');

    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error al procesar los archivos: ' . $e->getMessage());
    }
}
    // Mostrar el formulario del Paso 4
    public function mostrarPaso4()
    {
        return view('cursos.paso4');
    }

    // Guardar los datos del Paso 4 y redirigir al siguiente paso
    public function guardarPaso4(Request $request)
    {
        $validated = $request->validate([
            'Temario' => 'required|string|max:255',
            'DriveTemario' => 'required|string|max:255',
            'Itinerario' => 'required|string|max:255',
            'DriveItinerario' => 'required|string|max:255',
            'Planeación' => 'required|string|max:255',
            'DrivePlaneación' => 'required|string|max:255',
        ]);

        // Guardar los datos del Paso 4 en sesión
        session(['cursos_paso4' => $validated]);

        return redirect()->route('curso.paso5');
    }
    // Mostrar el formulario del Paso 5
    public function mostrarPaso5()
    {
        return view('cursos.paso5');
    }

    // Guardar los datos del Paso 5 y redirigir al siguiente paso
    public function guardarPaso5(Request $request)
    {
        $validated = $request->validate([
            'Digital' => 'required|string|max:255',
            'DriveDigital' => 'required|string|max:255',
            'Impreso_Presentable' => 'required|string|max:255',
        ]);

        // Guardar los datos del Paso 5 en sesión
        session(['cursos_paso5' => $validated]);

        return redirect()->route('curso.paso6');
    }

    // Mostrar el formulario del Paso 6
    public function mostrarPaso6()
    {
        return view('cursos.paso6');
    }

    // Guardar los datos del Paso 6 y redirigir al siguiente paso
    public function guardarPaso6(Request $request)
    {
        $validated = $request->validate([
            'Presentación' => 'required|string|max:255',
            'Evaluación_diagnostica' => 'required|string|max:255',
            'EvaluaciondeSatisfacción' => 'required|string|max:255',
            'EvaluacionFinal' => 'required|string|max:255',
            'DC3' => 'required|string|in:Tiene DC3,No tiene DC3,Por confirmar',
        ]);

        // Guardar los datos del Paso 6 en sesión
        session(['cursos_paso6' => $validated]);

        return redirect()->route('curso.paso7');
    }

    // Mostrar el formulario del Paso 7
    public function mostrarPaso7()
    {
        return view('cursos.paso7');
    }

    // Guardar los datos del Paso 7 y finalizar
    public function guardarPaso7(Request $request)
    {
        try {
            // Validar los datos del paso 7
            $validatedPaso7 = $request->validate([
                'FechadeRegistro_STPS' => 'nullable|date',
                'Formato_DC5' => 'required|string|max:255',
                'Formato_DC5_Tienefirma' => 'required|string|in:Si,No',
                'Certificadodecomprobacion' => 'required|string|max:255',
                'DrivedeCertificadodecomprobacion' => 'required|string|max:255',
                'Cartapoder_tienefirma' => 'required|string|in:Si,No',
                'DriveCartapoder' => 'required|string|max:255',
                'UDEMY' => 'required|string|max:255',
            ]);

            // Obtener todos los datos de la sesión
            $paso1 = session('cursos_paso1');
            $paso2 = session('cursos_paso2');
            $paso3 = session('cursos_paso3');
            $paso4 = session('cursos_paso4');
            $paso5 = session('cursos_paso5');
            $paso6 = session('cursos_paso6');

            // Verificar que todos los pasos anteriores existan
            if (!$paso1 || !$paso2 || !$paso3 || !$paso4 || !$paso5 || !$paso6) {
                Log::warning('Faltan datos de pasos anteriores al intentar crear un curso');
                return redirect()->route('curso.paso1')
                    ->with('error', 'Por favor complete todos los pasos del formulario');
            }

            // Combinar todos los datos
            $cursoData = array_merge(
                $paso1,
                $paso2,
                $paso3,
                $paso4,
                $paso5,
                $paso6,
                $validatedPaso7
            );

            Log::info('Intentando crear curso con datos:', ['data' => $cursoData]);

            // Crear el nuevo curso
            $curso = Cursos::create($cursoData);

            if (!$curso) {
                throw new \Exception('No se pudo crear el curso');
            }

            Log::info('Curso creado exitosamente', ['curso_id' => $curso->id]);

            // Limpiar los datos de la sesión
            session()->forget([
                'cursos_paso1',
                'cursos_paso2',
                'cursos_paso3',
                'cursos_paso4',
                'cursos_paso5',
                'cursos_paso6'
            ]);

            // Redireccionar al index con mensaje de éxito
            return redirect()->route('cursos.index')
                ->with('success', 'Curso creado exitosamente');

        } catch (\Exception $e) {
            Log::error('Error al crear curso: ' . $e->getMessage(), [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->withInput()
                ->with('error', 'Hubo un error al guardar el curso: ' . $e->getMessage());
        }
    }

    public function editPaso(Cursos $curso, $paso)
    {
        switch($paso) {
            case 1:
                return view('cursos.edit-paso1', compact('curso'));
            case 2:
                return view('cursos.edit-paso2', compact('curso'));
            case 3:
                return view('cursos.edit-paso3', compact('curso'));
            case 4:
                return view('cursos.edit-paso4', compact('curso'));
            case 5:
                return view('cursos.edit-paso5', compact('curso'));
            case 6:
                return view('cursos.edit-paso6', compact('curso'));
            case 7:
                return view('cursos.edit-paso7', compact('curso'));
            default:
                return redirect()->route('cursos.index')->with('error', 'Paso no válido');
        }
    }

    public function updatePaso(Request $request, Cursos $curso, $paso)
    {
        try {
            switch($paso) {
                case 1:
                    $validated = $request->validate([
                        'Nomenclatura' => 'required|string|max:255',
                        'NombredelCurso' => 'required|string|max:255',
                        'DescripciondeCurso' => 'required|string',
                        'CostodelCurso' => 'required|numeric',
                        'InstructorResponsable' => 'required|string|max:255',
                        'FechadeInicio' => 'required|date',
                        'FechadeTermino' => 'required|date|after_or_equal:FechadeInicio',
                        'Duracioncurso' => 'required|string|max:100',
                    ]);
                    break;
                case 2:
                    $validated = $request->validate([
                        'Virtual' => 'required|in:Si,No',
                        'Presencial' => 'required|in:Si,No',
                        'Mixto' => 'required|in:Si,No',
                    ]);
                    break;
                case 3:
                    $validated = $request->validate([
                        'SinFecha' => 'required|string|max:255',
                        'DriveSinFecha' => 'required|string|max:255',
                        'Facebook' => 'required|string|max:255',
                        'DriveFacebook' => 'required|string|max:255',
                        'Linkedin' => 'required|string|max:255',
                        'DriveLinkedin' => 'required|string|max:255',
                        'Instagram' => 'required|string|max:255',
                        'DriveInstagram' => 'required|string|max:255',
                    ]);
                    break;
                case 4:
                    $validated = $request->validate([
                        'Temario' => 'required|string|max:255',
                        'DriveTemario' => 'required|string|max:255',
                        'Itinerario' => 'required|string|max:255',
                        'DriveItinerario' => 'required|string|max:255',
                        'Planeación' => 'required|string|max:255',
                        'DrivePlaneación' => 'required|string|max:255',
                    ]);
                    break;
                case 5:
                    $validated = $request->validate([
                        'Digital' => 'required|string|max:255',
                        'DriveDigital' => 'required|string|max:255',
                        'Impreso_Presentable' => 'required|string|max:255',
                    ]);
                    break;
                case 6:
                    $validated = $request->validate([
                        'Presentación' => 'required|string|max:255',
                        'Evaluación_diagnostica' => 'required|string|max:255',
                        'EvaluaciondeSatisfacción' => 'required|string|max:255',
                        'EvaluacionFinal' => 'required|string|max:255',
                        'DC3' => 'required|string|in:Tiene DC3,No tiene DC3,Por confirmar',
                    ]);
                    break;
                case 7:
                    $validated = $request->validate([
                        'FechadeRegistro_STPS' => 'nullable|date',
                        'Formato_DC5' => 'required|string|max:255',
                        'Formato_DC5_Tienefirma' => 'required|string|in:Si,No',
                        'Certificadodecomprobacion' => 'required|string|max:255',
                        'DrivedeCertificadodecomprobacion' => 'required|string|max:255',
                        'Cartapoder_tienefirma' => 'required|string|in:Si,No',
                        'DriveCartapoder' => 'required|string|max:255',
                        'UDEMY' => 'required|string|max:255',
                    ]);
                    break;
                default:
                    return redirect()->route('cursos.index')->with('error', 'Paso no válido');
            }

            $curso->update($validated);

            return redirect()->route('cursos.edit', $curso->id)
                ->with('success', "Paso $paso actualizado exitosamente");

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Hubo un error al actualizar el curso: ' . $e->getMessage());
        }
    }

    public function exportarExcel()
    {
        $cursos = Cursos::all();
        return Excel::download(new CursosExport($cursos), 'cursos.xlsx');
    }

    public function exportarCsv()
    {
        $cursos = Cursos::all();
        return Excel::download(new CursosExport($cursos), 'cursos.csv');
    }

    public function getFechaInicio($id)
    {
        $curso = Cursos::findOrFail($id);
        return response()->json(['fecha_inicio' => $curso->FechadeInicio]);
    }

    public function crearCarpeta(Request $request)
    {
        try {
            // Validar la solicitud
            $request->validate([
                'tipo' => 'required|string',
                'nombreCarpeta' => 'required|string'
            ]);

            // Obtener la configuración de ruta base
            $configJson = Storage::get('config/ruta_archivos.json');
            $config = json_decode($configJson, true);

            if (!$config) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: No se ha configurado la ruta de archivos.'
                ], 400);
            }

            // Normalizar la ruta base
            $rutaBase = str_replace('\\', '/', $config['rutaCarpeta']); // Usar 'rutaCarpeta' en lugar de 'rutaCompleta'
            $nombreCarpeta = trim($request->nombreCarpeta);
            $tipo = trim($request->tipo);

            // Construir la ruta completa
            $rutaCompleta = $rutaBase . '/' . $tipo . '/' . $nombreCarpeta;

            // Verificar si la carpeta ya existe
            if (File::exists($rutaCompleta)) {
                return response()->json([
                    'success' => false,
                    'message' => 'La carpeta ya existe.'
                ], 400);
            }

            // Crear la carpeta
            File::makeDirectory($rutaCompleta, 0755, true);

            return response()->json([
                'success' => true,
                'message' => 'Carpeta creada exitosamente',
                'ruta' => $rutaCompleta
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear la carpeta: ' . $e->getMessage()
            ], 500);
        }
    }
    public function subirArchivo(Request $request)
    {
        try {
            // Validar la solicitud
            $request->validate([
                'archivo' => 'required|file',
                'tipo' => 'required|string',
                'nombreCarpeta' => 'required|string'
            ]);

            // Leer el archivo de configuración
            $configJson = Storage::get('config/ruta_archivos.json');
            $config = json_decode($configJson, true);

            if (!$config) {
                Log::error('Archivo de configuración no encontrado o inválido.');
                return response()->json([
                    'success' => false,
                    'message' => 'Error: No se ha configurado la ruta de archivos.'
                ], 400);
            }

            // Normalizar la ruta base
            $rutaBase = str_replace('\\', '/', $config['rutaCompleta']);
            $tipo = $request->tipo;
            $nombreCarpeta = $request->nombreCarpeta;
            $archivo = $request->file('archivo');

            // Construir la ruta completa
            $rutaCompleta = $rutaBase . '/' . $tipo . '/' . $nombreCarpeta;

            // Verificar si la carpeta existe, si no, crearla
            if (!File::exists($rutaCompleta)) {
                Log::info('Creando carpeta: ' . $rutaCompleta);
                File::makeDirectory($rutaCompleta, 0755, true);
            }

            // Mover el archivo
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            Log::info('Intentando mover archivo a: ' . $rutaCompleta . '/' . $nombreArchivo);
            $archivo->move($rutaCompleta, $nombreArchivo);

            // Respuesta exitosa
            return response()->json([
                'success' => true,
                'message' => 'Archivo subido exitosamente',
                'ruta' => $tipo . '/' . $nombreCarpeta . '/' . $nombreArchivo
            ]);

        } catch (\Exception $e) {
            Log::error('Error al subir archivo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al subir el archivo: ' . $e->getMessage()
            ], 500);
        }
    }
}

