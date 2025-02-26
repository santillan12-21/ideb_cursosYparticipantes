<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cursos;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CursosExport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\CourseActionLog;
use Illuminate\Support\Facades\Hash;


class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener solo los cursos con status = 1 (activos)
        $cursos = Cursos::where('status', 1)->get();

        // Pasar los cursos a la vista
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
            // Buscar el curso por ID
            $curso = Cursos::findOrFail($id);

            // Actualizar el campo 'status' a 0 (inactivo)
            $curso->update(['status' => 0]);

            // Registrar la acción de eliminación
            CourseActionLog::create([
                'curso_id' => $curso->id,
                'nombre_curso' => $curso->NombredelCurso,
                'user_id' => Auth::id(),
                'accion' => 'Eliminado',
                'detalles' => 'Curso desactivado por el usuario.',
                'fecha_accion' => now(),
            ]);

            // Redirigir con mensaje de éxito
            return redirect()->route('cursos.index')
                ->with('success', 'Curso desactivado exitosamente');
        } catch (\Exception $e) {
            // Redirigir con mensaje de error en caso de excepción
            return back()
                ->with('error', 'Error al desactivar el curso: ' . $e->getMessage());
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

        // Obtener la configuración de ruta base
        $configJson = Storage::get('config/ruta_archivos.json');
        $config = json_decode($configJson, true);

        if (!is_array($config) || empty($config)) {
            return redirect()->back()->with('error', 'Error: No se ha configurado la ruta de archivos.');
        }

        // Obtener la última ruta registrada
        $ultimaRuta = end($config); // Obtener el último elemento del array
        if (!isset($ultimaRuta['rutaCompleta'])) {
            return redirect()->back()->with('error', 'Error: La configuración de rutas no tiene el formato correcto.');
        }

        $rutaBase = $ultimaRuta['rutaCompleta']; // Usar la ruta completa (incluye la carpeta específica)

        // Crear carpetas para cada tipo si no existen
        $carpetas = ['SinFecha', 'Facebook', 'LinkedIn', 'Instagram'];
        foreach ($carpetas as $carpeta) {
            $rutaCarpeta = $rutaBase . DIRECTORY_SEPARATOR . $carpeta;

            // Verificar si la carpeta ya existe
            if (!File::exists($rutaCarpeta)) {
                File::makeDirectory($rutaCarpeta, 0755, true);
                Log::info("La carpeta '$carpeta' ha sido creada en la ruta base.");
            } else {
                Log::info("La carpeta '$carpeta' ya existe en la ruta base.");
            }
        }

        // Guardar archivos si fueron subidos
        $rutasArchivos = [];

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
        session([
            'cursos_paso3' => array_merge($validated, $rutasArchivos)
        ]);

        return redirect()->route('curso.paso4')->with('success', 'Carpeta creada y archivos guardados correctamente.');

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
        try {
            // Validar los datos del formulario
            $validated = $request->validate([
                'Temario' => 'required|string|max:255',
                'DriveTemario' => 'nullable|string|max:255', // Changed to nullable
                'Itinerario' => 'required|string|max:255',
                'DriveItinerario' => 'nullable|string|max:255', // Changed to nullable
                'Planeación' => 'required|string|max:255',
                'DrivePlaneación' => 'nullable|string|max:255', // Changed to nullable
                'TemarioLocal' => 'nullable|file',
                'ItinerarioLocal' => 'nullable|file',
                'PlaneaciónLocal' => 'nullable|file',
            ]);

            // Obtener la configuración de ruta base
            $configJson = Storage::get('config/ruta_archivos.json');
            $config = json_decode($configJson, true);

            if (!is_array($config) || empty($config)) {
                return redirect()->back()->with('error', 'Error: No se ha configurado la ruta de archivos.');
            }

            $ultimaRuta = end($config);
            $rutaBase = $ultimaRuta['rutaCompleta'];

            // Procesar archivos locales
            $rutasArchivos = [];

            if ($request->hasFile('TemarioLocal')) {
                $archivo = $request->file('TemarioLocal');
                $nombreArchivo = time() . '_temario_' . $archivo->getClientOriginalName();
                $rutaCarpeta = $rutaBase . DIRECTORY_SEPARATOR . 'Temario';
                if (!File::exists($rutaCarpeta)) {
                    File::makeDirectory($rutaCarpeta, 0755, true);
                }
                $archivo->move($rutaCarpeta, $nombreArchivo);
                $rutasArchivos['TemarioLocal'] = 'Temario/' . $nombreArchivo;
            }

            if ($request->hasFile('ItinerarioLocal')) {
                $archivo = $request->file('ItinerarioLocal');
                $nombreArchivo = time() . '_itinerario_' . $archivo->getClientOriginalName();
                $rutaCarpeta = $rutaBase . DIRECTORY_SEPARATOR . 'Itinerario';
                if (!File::exists($rutaCarpeta)) {
                    File::makeDirectory($rutaCarpeta, 0755, true);
                }
                $archivo->move($rutaCarpeta, $nombreArchivo);
                $rutasArchivos['ItinerarioLocal'] = 'Itinerario/' . $nombreArchivo;
            }

            if ($request->hasFile('PlaneaciónLocal')) {
                $archivo = $request->file('PlaneaciónLocal');
                $nombreArchivo = time() . '_planeacion_' . $archivo->getClientOriginalName();
                $rutaCarpeta = $rutaBase . DIRECTORY_SEPARATOR . 'Planeación';
                if (!File::exists($rutaCarpeta)) {
                    File::makeDirectory($rutaCarpeta, 0755, true);
                }
                $archivo->move($rutaCarpeta, $nombreArchivo);
                $rutasArchivos['PlaneaciónLocal'] = 'Planeación/' . $nombreArchivo;
            }

            // Guardar los datos del Paso 4 en sesión
            session(['cursos_paso4' => array_merge($validated, $rutasArchivos)]);

            return redirect()->route('curso.paso5');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Error al guardar los datos del Paso 4: ' . $e->getMessage());
        }
    }
    // Mostrar el formulario del Paso 5
    public function mostrarPaso5()
    {
        return view('cursos.paso5');
    }

    // Guardar los datos del Paso 5 y redirigir al siguiente paso
    public function guardarPaso5(Request $request)
{
    try {
        // 1. Validar los datos del formulario
        $validated = $request->validate([
            'Digital' => 'required|string|max:255',
            'DriveDigital' => 'nullable|string|max:255',
            'Impreso_Presentable' => 'required|string|max:255',
            'DigitalLocal' => 'nullable|file',
            'ImpresoPresentableLocal' => 'nullable|file', // Nuevo campo para archivos locales de "Impreso Presentable"
        ]);

        // 2. Obtener la configuración de ruta base desde el archivo JSON
        $configJson = Storage::get('config/ruta_archivos.json');
        $config = json_decode($configJson, true);
        if (!is_array($config) || empty($config)) {
            return redirect()->back()->with('error', 'Error: No se ha configurado la ruta de archivos.');
        }
        $rutaBase = end($config)['rutaCompleta']; // Obtener la última ruta configurada

        // 3. Procesar archivos locales (si existen)
        $rutasArchivos = [];

        // Procesar archivo DigitalLocal
        if ($request->hasFile('DigitalLocal')) {
            $archivo = $request->file('DigitalLocal');
            $nombreArchivo = time() . '_digital_' . $archivo->getClientOriginalName(); // Nombre único para el archivo
            $rutaCarpeta = $rutaBase . DIRECTORY_SEPARATOR . 'Digital'; // Ruta específica para "Digital"

            // Crear la carpeta si no existe
            if (!File::exists($rutaCarpeta)) {
                File::makeDirectory($rutaCarpeta, 0755, true);
            }

            // Mover el archivo a la carpeta correspondiente
            $archivo->move($rutaCarpeta, $nombreArchivo);

            // Guardar la ruta relativa del archivo en el array de rutas
            $rutasArchivos['DigitalLocal'] = 'Digital/' . $nombreArchivo;
        }

        // Procesar archivo ImpresoPresentableLocal
        if ($request->hasFile('ImpresoPresentableLocal')) {
            $archivo = $request->file('ImpresoPresentableLocal');
            $nombreArchivo = time() . '_impreso_presentable_' . $archivo->getClientOriginalName(); // Nombre único para el archivo
            $rutaCarpeta = $rutaBase . DIRECTORY_SEPARATOR . 'ImpresoPresentable'; // Ruta específica para "Impreso Presentable"

            // Crear la carpeta si no existe
            if (!File::exists($rutaCarpeta)) {
                File::makeDirectory($rutaCarpeta, 0755, true);
            }

            // Mover el archivo a la carpeta correspondiente
            $archivo->move($rutaCarpeta, $nombreArchivo);

            // Guardar la ruta relativa del archivo en el array de rutas
            $rutasArchivos['ImpresoPresentableLocal'] = 'ImpresoPresentable/' . $nombreArchivo;
        }

        // 4. Guardar los datos del Paso 5 en sesión
        session(['cursos_paso5' => array_merge($validated, $rutasArchivos)]);

        // 5. Redirigir al siguiente paso
        return redirect()->route('curso.paso6');
    } catch (\Exception $e) {
        // Manejar errores y redirigir con un mensaje de error
        return back()
            ->withInput()
            ->with('error', 'Error al guardar los datos del Paso 5: ' . $e->getMessage());
    }
}

    // Mostrar el formulario del Paso 6
    public function mostrarPaso6()
    {
        return view('cursos.paso6');
    }

    // Guardar los datos del Paso 6 y redirigir al siguiente paso
    public function guardarPaso6(Request $request)
{
    try {
        // 1. Validar los datos del formulario
        $validated = $request->validate([
            'Presentación' => 'required|string|max:255',
            'Evaluación_diagnostica' => 'required|string|max:255',
            'EvaluaciondeSatisfacción' => 'required|string|max:255',
            'EvaluacionFinal' => 'required|string|max:255',
            'PresentacionLocal' => 'nullable|file',
            'EvaluacionDiagnosticaLocal' => 'nullable|file',
            'EvaluacionSatisfaccionLocal' => 'nullable|file',
            'EvaluacionFinalLocal' => 'nullable|file',
            'DC3' => 'required|string|max:255',
        ]);

        // 2. Obtener la configuración de ruta base desde el archivo JSON
        $configJson = Storage::get('config/ruta_archivos.json');
        $config = json_decode($configJson, true);
        if (!is_array($config) || empty($config)) {
            return redirect()->back()->with('error', 'Error: No se ha configurado la ruta de archivos.');
        }
        $rutaBase = end($config)['rutaCompleta']; // Obtener la última ruta configurada

        // 3. Crear la carpeta "Evaluaciones" si no existe
        $rutaEvaluaciones = $rutaBase . DIRECTORY_SEPARATOR . 'Evaluaciones';
        if (!File::exists($rutaEvaluaciones)) {
            File::makeDirectory($rutaEvaluaciones, 0755, true);
        }

        // 4. Procesar archivos locales (si existen)
        $rutasArchivos = [];

        // Procesar archivo PresentacionLocal
        if ($request->hasFile('PresentacionLocal')) {
            $archivo = $request->file('PresentacionLocal');
            $nombreArchivo = time() . '_presentacion_' . $archivo->getClientOriginalName();
            $rutaCarpeta = $rutaEvaluaciones . DIRECTORY_SEPARATOR . 'Presentacion';
            if (!File::exists($rutaCarpeta)) {
                File::makeDirectory($rutaCarpeta, 0755, true);
            }
            $archivo->move($rutaCarpeta, $nombreArchivo);
            $rutasArchivos['PresentacionLocal'] = 'Evaluaciones/Presentacion/' . $nombreArchivo;
        }

        // Procesar archivo EvaluacionDiagnosticaLocal
        if ($request->hasFile('EvaluacionDiagnosticaLocal')) {
            $archivo = $request->file('EvaluacionDiagnosticaLocal');
            $nombreArchivo = time() . '_evaluacion_diagnostica_' . $archivo->getClientOriginalName();
            $rutaCarpeta = $rutaEvaluaciones . DIRECTORY_SEPARATOR . 'EvaluacionDiagnostica';
            if (!File::exists($rutaCarpeta)) {
                File::makeDirectory($rutaCarpeta, 0755, true);
            }
            $archivo->move($rutaCarpeta, $nombreArchivo);
            $rutasArchivos['EvaluacionDiagnosticaLocal'] = 'Evaluaciones/EvaluacionDiagnostica/' . $nombreArchivo;
        }

        // Procesar archivo EvaluacionSatisfaccionLocal
        if ($request->hasFile('EvaluacionSatisfaccionLocal')) {
            $archivo = $request->file('EvaluacionSatisfaccionLocal');
            $nombreArchivo = time() . '_evaluacion_satisfaccion_' . $archivo->getClientOriginalName();
            $rutaCarpeta = $rutaEvaluaciones . DIRECTORY_SEPARATOR . 'EvaluacionSatisfaccion';
            if (!File::exists($rutaCarpeta)) {
                File::makeDirectory($rutaCarpeta, 0755, true);
            }
            $archivo->move($rutaCarpeta, $nombreArchivo);
            $rutasArchivos['EvaluacionSatisfaccionLocal'] = 'Evaluaciones/EvaluacionSatisfaccion/' . $nombreArchivo;
        }

        // Procesar archivo EvaluacionFinalLocal
        if ($request->hasFile('EvaluacionFinalLocal')) {
            $archivo = $request->file('EvaluacionFinalLocal');
            $nombreArchivo = time() . '_evaluacion_final_' . $archivo->getClientOriginalName();
            $rutaCarpeta = $rutaEvaluaciones . DIRECTORY_SEPARATOR . 'EvaluacionFinal';
            if (!File::exists($rutaCarpeta)) {
                File::makeDirectory($rutaCarpeta, 0755, true);
            }
            $archivo->move($rutaCarpeta, $nombreArchivo);
            $rutasArchivos['EvaluacionFinalLocal'] = 'Evaluaciones/EvaluacionFinal/' . $nombreArchivo;
        }

        // 5. Guardar los datos del Paso 6 en sesión
        session(['cursos_paso6' => array_merge($validated, $rutasArchivos)]);

        // 6. Redirigir al siguiente paso
        return redirect()->route('curso.paso7');
    } catch (\Exception $e) {
        // Manejar errores y redirigir con un mensaje de error
        return back()
            ->withInput()
            ->with('error', 'Error al guardar los datos del Paso 6: ' . $e->getMessage());
    }
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
                'Formato_DC5' => 'nullable|string|max:255',
                'Formato_DC5_Tienefirma' => 'required|string|in:Si,No',
                'Certificadodecomprobacion' => 'required|string|max:255',
                'DrivedeCertificadodecomprobacion' => 'nullable|string|max:255',
                'Cartapoder_tienefirma' => 'required|string|in:Si,No',
                'DriveCartapoder' => 'nullable|string|max:255',
                'UDEMY' => 'required|string|max:255',
                'FormatoDC5Local' => 'nullable|file',
                'CertificadoComprobacionLocal' => 'nullable|file',
                'CartaPoderLocal' => 'nullable|file',
                'UDEMYLocal' => 'nullable|file',
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

            // Obtener la configuración de ruta base
            $configJson = Storage::get('config/ruta_archivos.json');
            $config = json_decode($configJson, true);

            // Ordenar por timestamp y obtener la última ruta configurada
            usort($config, function ($a, $b) {
                return strtotime($b['timestamp']) - strtotime($a['timestamp']);
            });

            $rutaBase = $config[0]['rutaCompleta'] ?? null;

            if (!$rutaBase) {
                return back()
                    ->withInput()
                    ->with('error', 'Error: No se ha configurado la ruta de archivos.');
            }

            // Crear carpetas para cada tipo si no existen
            $carpetas = ['FormatoDC5', 'CertificadoComprobacion', 'CartaPoder'];
            foreach ($carpetas as $carpeta) {
                $rutaCarpeta = $rutaBase . DIRECTORY_SEPARATOR . $carpeta;
                if (!File::exists($rutaCarpeta)) {
                    File::makeDirectory($rutaCarpeta, 0755, true);
                }
            }

            // Guardar archivos locales
            $rutasArchivos = [];

            if ($request->hasFile('FormatoDC5Local')) {
                $archivo = $request->file('FormatoDC5Local');
                $nombreArchivo = time() . '_formatodc5_' . $archivo->getClientOriginalName();
                $archivo->move($rutaBase . DIRECTORY_SEPARATOR . 'FormatoDC5', $nombreArchivo);
                $rutasArchivos['FormatoDC5Local'] = 'FormatoDC5/' . $nombreArchivo;
            }

            if ($request->hasFile('CertificadoComprobacionLocal')) {
                $archivo = $request->file('CertificadoComprobacionLocal');
                $nombreArchivo = time() . '_certificadocomprobacion_' . $archivo->getClientOriginalName();
                $archivo->move($rutaBase . DIRECTORY_SEPARATOR . 'CertificadoComprobacion', $nombreArchivo);
                $rutasArchivos['CertificadoComprobacionLocal'] = 'CertificadoComprobacion/' . $nombreArchivo;
            }

            if ($request->hasFile('CartaPoderLocal')) {
                $archivo = $request->file('CartaPoderLocal');
                $nombreArchivo = time() . '_cartapoder_' . $archivo->getClientOriginalName();
                $archivo->move($rutaBase . DIRECTORY_SEPARATOR . 'CartaPoder', $nombreArchivo);
                $rutasArchivos['CartaPoderLocal'] = 'CartaPoder/' . $nombreArchivo;
            }


            if ($request->hasFile('UDEMYLocal')) {
                $archivo = $request->file('UDEMYLocal');
                $nombreArchivo = time() . '_udemy_' . $archivo->getClientOriginalName();
                $rutaCarpeta = $rutaBase . DIRECTORY_SEPARATOR . 'UDEMY';
                if (!File::exists($rutaCarpeta)) {
                    File::makeDirectory($rutaCarpeta, 0755, true);
                }
                $archivo->move($rutaCarpeta, $nombreArchivo);
                $rutasArchivos['UDEMYLocal'] = 'UDEMY/' . $nombreArchivo;
            }

            // Combinar todos los datos
            $cursoData = array_merge(
                $paso1,
                $paso2,
                $paso3,
                $paso4,
                $paso5,
                $paso6,
                $validatedPaso7,
                $rutasArchivos // Agregar las rutas de los archivos locales
            );

            Log::info('Intentando crear curso con datos:', ['data' => $cursoData]);

            // Crear el nuevo curso
            $curso = Cursos::create($cursoData);

            // Registrar la acción de creación
            CourseActionLog::create([
                'curso_id' => $curso->id,
                'nombre_curso' => $curso->NombredelCurso,
                'user_id' => Auth::id(),
                'accion' => 'Creado',
                'detalles' => 'Curso creado por el usuario.',
                'fecha_accion' => now(),
            ]);

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
            // Registrar la acción de edición
            CourseActionLog::create([
                'curso_id' => $curso->id,
                'nombre_curso' => $curso->NombredelCurso,
                'user_id' => Auth::id(),
                'accion' => 'Editado',
                'detalles' => "El paso $paso del curso fue actualizado.",
                'fecha_accion' => now(),
            ]);

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

            // Leer el archivo de configuración
            $configJson = Storage::get('config/ruta_archivos.json');
            $config = json_decode($configJson, true);

            if (!is_array($config) || empty($config)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: No se ha configurado la ruta de archivos.'
                ], 400);
            }

            // Obtener la última ruta registrada
            $ultimaRuta = end($config); // Obtener el último elemento del array
            if (!isset($ultimaRuta['rutaCompleta'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: La configuración de rutas no tiene el formato correcto.'
                ], 400);
            }

            // Normalizar la ruta base
            $rutaBase = str_replace('\\', '/', $ultimaRuta['rutaCompleta']);
            $nombreCarpeta = trim($request->nombreCarpeta);

            // Construir la ruta completa
            $rutaCompleta = $rutaBase . '/' . $nombreCarpeta;

            // Verificar si la carpeta ya existe
            if (File::exists($rutaCompleta)) {
                return response()->json([
                    'success' => false,
                    'message' => 'La carpeta ya existe. Crea otra carpeta para guardar la informacion o omite este paso.'
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
                'nombreCarpeta' => 'required|string'
            ]);

            // Leer el archivo de configuración
            $configJson = Storage::get('config/ruta_archivos.json');
            $config = json_decode($configJson, true);

            if (!is_array($config) || empty($config)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: No se ha configurado la ruta de archivos.'
                ], 400);
            }

            // Obtener la última ruta registrada
            $ultimaRuta = end($config); // Obtener el último elemento del array
            if (!isset($ultimaRuta['rutaCompleta'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: La configuración de rutas no tiene el formato correcto.'
                ], 400);
            }

            // Normalizar la ruta base
            $rutaBase = str_replace('\\', '/', $ultimaRuta['rutaCompleta']);
            $nombreCarpeta = trim($request->nombreCarpeta);
            $archivo = $request->file('archivo');

            // Construir la ruta completa
            $rutaCompleta = $rutaBase . '/' . $nombreCarpeta;

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
                'ruta' => $nombreCarpeta . '/' . $nombreArchivo
            ]);

        } catch (\Exception $e) {
            Log::error('Error al subir archivo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error al subir el archivo: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verificarCarpeta(Request $request)
    {
        try {
            // Obtener la ruta seleccionada desde la solicitud
            $rutaSeleccionada = $request->input('rutaSeleccionada');

            // Verificar si la carpeta ya tiene subcarpetas
            if (File::exists($rutaSeleccionada) && count(File::directories($rutaSeleccionada)) > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Esta carpeta ya tiene subcarpetas creadas. Se recomienda crear una nueva carpeta para el curso.'
                ], 400);
            }

            // Si no hay subcarpetas, retornar éxito
            return response()->json([
                'success' => true,
                'message' => 'La carpeta está disponible para crear un nuevo curso.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al verificar la carpeta: ' . $e->getMessage()
            ], 500);
        }
    }

    public function mostrarLogs()
    {
        $logs = CourseActionLog::with(['curso', 'user'])->get();
        return view('configuraciones.show-log', compact('logs'));
    }

    public function activarCurso($id)
    {
        try {
            // Buscar el curso por ID
            $curso = Cursos::findOrFail($id);

            // Actualizar el campo 'status' a 1 (activo)
            $curso->update(['status' => 1]);

            // Redirigir con mensaje de éxito
            return redirect()->route('configuraciones.index')
                ->with('success', 'Curso activado exitosamente');
        } catch (\Exception $e) {
            // Redirigir con mensaje de error en caso de excepción
            return back()
                ->with('error', 'Error al activar el curso: ' . $e->getMessage());
        }
    }

    public function eliminarDefinitivo(Request $request, $id)
    {
        try {
            // Verificar que el usuario esté autenticado
            if (!Auth::check()) {
                return back()->with('error', 'Debes iniciar sesión para realizar esta acción.');
            }

            // Validar la solicitud
            $request->validate([
                'password' => 'required|string',
            ]);

            // Verificar que la contraseña sea correcta
            if (!Hash::check($request->password, Auth::user()->password)) {
                return back()->with('error', 'Contraseña incorrecta. No se pudo eliminar el curso.');
            }

            // Buscar el curso por ID
            $curso = Cursos::findOrFail($id);

            // Eliminar el curso definitivamente
            $curso->forceDelete();

            // Redirigir con mensaje de éxito
            return redirect()->route('configuraciones.index')
                ->with('success', 'Curso eliminado definitivamente.');
        } catch (\Exception $e) {
            // Redirigir con mensaje de error en caso de excepción
            return back()->with('error', 'Error al eliminar el curso: ' . $e->getMessage());
        }
    }


}

