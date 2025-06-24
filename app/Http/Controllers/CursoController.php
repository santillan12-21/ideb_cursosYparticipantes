<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cursos;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Log as LogFacade;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CursosExport;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\CourseActionLog;
use Illuminate\Support\Facades\Hash;
use App\Models\RutaLocal;
use Illuminate\Support\Str;
use App\Models\Inscripcion;
use App\Models\participantes;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
public function index(Request $request)
{
    $instructor = $request->get('instructor');

    if ($instructor) {
        $cursos = Cursos::with('ruta') // <- Aquí
            ->where('status', 1)
            ->where('InstructorResponsable', $instructor)
            ->get();
    } else {
        $cursos = Cursos::with('ruta') // <- Aquí también
            ->where('status', 1)
            ->whereNull('parent_id')
            ->get();
    }

    $subcursos = Cursos::with('ruta') // También podrías traer los subcursos con rutas
        ->where('status', 1)
        ->get();

    return view('cursos.index', compact('cursos', 'subcursos'));
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
    $coloresPorPaso = $this->calcularProgresoPaso($curso);
    return view('cursos.edit', compact('curso', 'coloresPorPaso'));
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
    $cursoId = session('curso_id');
    $curso = Cursos::find($cursoId);

    $datosPadre = null;

    if ($curso && $curso->parent_id) {
        // Cargar curso padre
        $datosPadre = Cursos::find($curso->parent_id);
    }

    return view('cursos.paso1', compact('curso', 'datosPadre'));
}


    // Guardar los datos del Paso 1 y redirigir al Paso 2
  public function guardarPaso1(Request $request)
{
    $validated = $request->validate([
        'Nomenclatura' => 'nullable|string|max:255',
        'NombredelCurso' => 'nullable|string|max:255',
        'DescripciondeCurso' => 'nullable|string|max:255',
        'CostodelCurso' => 'nullable|numeric',
        'InstructorResponsable' => 'nullable|string|max:255',
        'FechadeInicio' => 'nullable|date',
        'FechadeTermino' => 'nullable|date|after_or_equal:FechadeInicio',
        'Duracioncurso' => 'nullable|string|max:255',
    ]);

    $curso_id = session('curso_id');

    if (!$curso_id) {
        Log::error('No se encontró el ID del curso en la sesión durante paso1');
        return redirect()->route('cursos.index')->with('error', 'Error al procesar el curso. Por favor, inicie nuevamente.');
    }

    $curso = Cursos::find($curso_id);

    if ($curso->parent_id && empty($curso->Nomenclatura)) {
    $curso_padre = Cursos::find($curso->parent_id);

    $nomenclatura_padre = $curso_padre->Nomenclatura ?? '000';
    $partes = explode('-', $nomenclatura_padre);
    $sufijo = count($partes) > 1 ? $partes[1] : $nomenclatura_padre;

    $anio = now()->format('y');

    // Obtener el último número incremental en nomenclaturas hijas
    $maxSufijo = Cursos::where('parent_id', $curso->parent_id)
        ->whereNotNull('Nomenclatura')
        ->get()
        ->map(function ($subcurso) {
            $partes = explode('.', $subcurso->Nomenclatura);
            return isset($partes[1]) ? (int)$partes[1] : 0;
        })
        ->max();

    $incremento = str_pad($maxSufijo + 1, 2, '0', STR_PAD_LEFT);
    $nomenclatura = "$anio-$sufijo.$incremento";

    $validated['Nomenclatura'] = $nomenclatura;
}


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
            'Virtual' => 'nullable|in:Si,No',
            'Presencial' => 'nullable|in:Si,No',
            'Mixto' => 'nullable|in:Si,No',
        ]);

        // Guardar los datos del Paso 2 en sesión
        session(['cursos_paso2' => $validated]);

        return redirect()->route('curso.paso3');
    }

    // Mostrar el formulario del Paso 3
    public function mostrarPaso3()
    {
        $ultimaRuta = RutaLocal::latest()->first();
        $carpetasExistentes = [];

        if ($ultimaRuta) {
            $tipos = ['SinFecha', 'Facebook', 'LinkedIn', 'Instagram'];
            foreach ($tipos as $tipo) {
                $carpeta = ucfirst($tipo);
                $ruta = $ultimaRuta->{"ruta$carpeta"} ?? '';
                $carpetasExistentes[$tipo] = File::exists($ruta);
            }
        }

        return view('cursos.paso3', compact('carpetasExistentes'));
    }

    // Guardar los datos del Paso 3 y redirigir al Paso 4
    public function guardarPaso3(Request $request)
{
    try {
        // Validar los datos del formulario
        $validated = $request->validate([
            'SinFecha' => 'nullable|string|max:255',
            'DriveSinFecha' => 'nullable|string|max:255',
            'Facebook' => 'nullable|string|max:255',
            'DriveFacebook' => 'nullable|string|max:255',
            'Linkedin' => 'nullable|string|max:255',
            'DriveLinkedin' => 'nullable|string|max:255',
            'Instagram' => 'nullable|string|max:255',
            'DriveInstagram' => 'nullable|string|max:255',
        ]);

        // Obtener la última ruta registrada desde la base de datos
        $ultimaRuta = RutaLocal::orderBy('created_at', 'desc')->first();

        if (!$ultimaRuta || empty($ultimaRuta->rutacompleta)) {
            Log::error("No se encontró una ruta válida en la base de datos.");
            return redirect()->back()->with('error', 'Error: No se ha configurado la ruta de archivos.');
        }

        // Normalizar la ruta
        $rutaBase = str_replace('\\', '/', $ultimaRuta->rutacompleta);

        // Verificar si la carpeta existe, si no, crearla
        if (!File::exists($rutaBase)) {
            File::makeDirectory($rutaBase, 0755, true);
            Log::info("Carpeta creada automáticamente: {$rutaBase}");
        }

        // Crear la carpeta principal "7- Flyers del Curso" si no existe
        $rutaFlyers = $rutaBase . '/7- Flyers del Curso';
        if (!File::exists($rutaFlyers)) {
            File::makeDirectory($rutaFlyers, 0755, true);
            Log::info("Carpeta '7- Flyers del Curso' creada en: {$rutaFlyers}");
        }

        // Guardar la ruta en la columna rutaformatosflyer
        $ultimaRuta->update([
            'rutaformatosflyer' => $rutaFlyers
        ]);

        // Crear subcarpetas dentro de "7- Flyers del Curso"
        $carpetas = ['SinFecha', 'Facebook', 'LinkedIn', 'Instagram'];
        foreach ($carpetas as $carpeta) {
            $rutaCarpeta = $rutaFlyers . '/' . $carpeta;
            if (!File::exists($rutaCarpeta)) {
                File::makeDirectory($rutaCarpeta, 0755, true);
                Log::info("Carpeta '{$carpeta}' creada en: {$rutaCarpeta}");
            }

            // Guardar las rutas de cada subcarpeta
            $columna = 'ruta' . $carpeta;
            $ultimaRuta->update([
                $columna => $rutaCarpeta
            ]);
        }

        // Guardar archivos si fueron subidos
        $rutasArchivos = [];

        if ($request->hasFile('SinFechaLocal')) {
            $archivo = $request->file('SinFechaLocal');
            $nombreArchivo = time() . '_sinfecha_' . $archivo->getClientOriginalName();
            $archivo->move($rutaFlyers . '/SinFecha', $nombreArchivo);
            $rutasArchivos['SinFechaLocal'] = '7- Flyers del Curso/SinFecha/' . $nombreArchivo;
        }

        if ($request->hasFile('FacebookLocal')) {
            $archivo = $request->file('FacebookLocal');
            $nombreArchivo = time() . '_facebook_' . $archivo->getClientOriginalName();
            $archivo->move($rutaFlyers . '/Facebook', $nombreArchivo);
            $rutasArchivos['FacebookLocal'] = '7- Flyers del Curso/Facebook/' . $nombreArchivo;
        }

        if ($request->hasFile('LinkedInLocal')) {
            $archivo = $request->file('LinkedInLocal');
            $nombreArchivo = time() . '_linkedin_' . $archivo->getClientOriginalName();
            $archivo->move($rutaFlyers . '/LinkedIn', $nombreArchivo);
            $rutasArchivos['LinkedInLocal'] = '7- Flyers del Curso/LinkedIn/' . $nombreArchivo;
        }

        if ($request->hasFile('InstagramLocal')) {
            $archivo = $request->file('InstagramLocal');
            $nombreArchivo = time() . '_instagram_' . $archivo->getClientOriginalName();
            $archivo->move($rutaFlyers . '/Instagram', $nombreArchivo);
            $rutasArchivos['InstagramLocal'] = '7- Flyers del Curso/Instagram/' . $nombreArchivo;
        }

        // Guardar los datos en la sesión
        session(['cursos_paso3' => array_merge($validated, $rutasArchivos)]);

        return redirect()->route('curso.paso4')->with('success', 'Carpeta creada y archivos guardados correctamente.');

    } catch (\Exception $e) {
        Log::error("Error al procesar los archivos: " . $e->getMessage());
        return redirect()->back()->with('error', 'Error al procesar los archivos: ' . $e->getMessage());
    }
}
   
public function mostrarPaso4()
{
    $cursoId = session('curso_id');
    $curso = Cursos::find($cursoId);

    // 👇 Esta parte la tomamos de crearPaso1()
    $datosPadre = null;
    if ($curso && $curso->parent_id) {
        $datosPadre = Cursos::find($curso->parent_id);
    }

    $rutaCurso = RutaLocal::where('id_cursos', $cursoId)->first();

    $archivosLocales = [
        'Temario' => null,
        'Itinerario' => null,
        'Planeacion' => null,
    ];

    if ($rutaCurso) {
        foreach ($archivosLocales as $tipo => &$valor) {
            $campo = 'ruta' . $tipo;

            if (!empty($rutaCurso->$campo)) {
                $valor = 'actual';
            } else {
                $valor = null;
            }
        }
        unset($valor);
    }

    return view('cursos.paso4', compact('curso', 'archivosLocales', 'datosPadre'));
}



    // Guardar los datos del Paso 4 y redirigir al siguiente paso
    public function guardarPaso4(Request $request)
    {
        try {
            // Validar los datos del formulario
            $validated = $request->validate([
                'Temario' => 'nullable|string|max:255',
                'DriveTemario' => 'nullable|string|max:255', // Changed to nullable
                'Itinerario' => 'nullable|string|max:255',
                'DriveItinerario' => 'nullable|string|max:255', // Changed to nullable
                'Planeación' => 'nullable|string|max:255',
                'DrivePlaneación' => 'nullable|string|max:255', // Changed to nullable
                'TemarioLocal' => 'nullable|file',
                'ItinerarioLocal' => 'nullable|file',
                'PlaneaciónLocal' => 'nullable|file',
            ]);

            // Obtener la última ruta registrada desde la base de datos
            $ultimaRuta = RutaLocal::orderBy('created_at', 'desc')->first();

            if (!$ultimaRuta || empty($ultimaRuta->rutacompleta)) {
                return redirect()->back()->with('error', 'Error: No se ha configurado la ruta de archivos.');
            }

            // Normalizar la ruta base
            $rutaBase = rtrim(str_replace('\\', '/', $ultimaRuta->rutacompleta), '/');

            // Crear las carpetas principales si no existen
            $carpetas = [
                '1-Temario',
                '6-Itinerario',
                '3-Planeación',
            ];

            $rutasActualizadas = [];

            foreach ($carpetas as $carpeta) {
                $rutaCompleta = $rutaBase . DIRECTORY_SEPARATOR . $carpeta;

                if (!File::exists($rutaCompleta)) {
                    File::makeDirectory($rutaCompleta, 0755, true);
                    Log::info("Carpeta creada: {$rutaCompleta}");
                } else {
                    Log::info("Carpeta ya existe: {$rutaCompleta}");
                }

                // Guardar las rutas en el array de actualización
                switch ($carpeta) {
                    case '1-Temario':
                        $rutasActualizadas['rutaTemario'] = $rutaCompleta;
                        break;
                    case '6-Itinerario':
                        $rutasActualizadas['rutaItinerario'] = $rutaCompleta;
                        break;
                    case '3-Planeación':
                        $rutasActualizadas['rutaPlaneacion'] = $rutaCompleta;
                        break;
                }
            }

            // Actualizar la base de datos con las nuevas rutas
            $ultimaRuta->update($rutasActualizadas);

            // Procesar archivos locales
            $rutasArchivos = [];

            if ($request->hasFile('TemarioLocal')) {
                $archivo = $request->file('TemarioLocal');
                $nombreArchivo = time() . '_temario_' . $archivo->getClientOriginalName();
                $archivo->move($rutasActualizadas['rutaTemario'], $nombreArchivo);
                $rutasArchivos['TemarioLocal'] = '1-Temario/' . $nombreArchivo;
            }

            if ($request->hasFile('ItinerarioLocal')) {
                $archivo = $request->file('ItinerarioLocal');
                $nombreArchivo = time() . '_itinerario_' . $archivo->getClientOriginalName();
                $archivo->move($rutasActualizadas['rutaItinerario'], $nombreArchivo);
                $rutasArchivos['ItinerarioLocal'] = '6-Itinerario/' . $nombreArchivo;
            }

            if ($request->hasFile('PlaneaciónLocal')) {
                $archivo = $request->file('PlaneaciónLocal');
                $nombreArchivo = time() . '_planeacion_' . $archivo->getClientOriginalName();
                $archivo->move($rutasActualizadas['rutaPlaneacion'], $nombreArchivo);
                $rutasArchivos['PlaneaciónLocal'] = '3-Planeación/' . $nombreArchivo;
            }

            // Guardar los datos del Paso 4 en sesión
            session(['cursos_paso4' => array_merge($validated, $rutasArchivos)]);

            return redirect()->route('curso.paso5')->with('success', 'Carpetas creadas y archivos guardados correctamente.');

        } catch (\Exception $e) {
            Log::error("Error al procesar los archivos: " . $e->getMessage());
            return back()
                ->withInput()
                ->with('error', 'Error al procesar los archivos: ' . $e->getMessage());
        }
    }
    public function mostrarPaso5()
{

    $cursoId = session('curso_id');
    $curso = Cursos::find($cursoId);

    // Si no hay curso, puedes redirigir o mostrar error
    if (!$curso) {
        return redirect()->back()->with('error', 'Curso no encontrado');
    }

    // Revisar si es duplicado (tiene padre)
    $datosPadre = null;
    if ($curso->parent_id) {
        $datosPadre = Cursos::find($curso->parent_id);
    }

    // Inicializa los tipos de archivos
    $archivosLocales = [
        'Materialdeapoyo' => null,
        'cursoenlinea' => null,
    ];

    // Mapeo de nombre lógico al campo en la BD
    $campoBD = [
        'Materialdeapoyo' => 'rutaMaterialdeapoyo',
        'cursoenlinea' => 'rutacursoenlinea',
    ];

    // Buscar la ruta local del curso actual
    $rutaCurso = RutaLocal::where('id_cursos', $cursoId)->first();

    if ($rutaCurso) {
        foreach ($archivosLocales as $tipo => $_) {
            $campo = $campoBD[$tipo] ?? null;

            // Validar existencia del campo
            if ($campo && !empty($rutaCurso->$campo)) {
                $archivosLocales[$tipo] = 'actual';
            }
        }
    }

    return view('cursos.paso5', compact('curso', 'archivosLocales', 'datosPadre'));
}

    // Guardar los datos del Paso 5 y redirigir al siguiente paso
    public function guardarPaso5(Request $request)
{
    try {
        // Validar los datos del formulario
        $validated = $request->validate([
            'Digital' => 'nullable|string|max:255',
            'DriveDigital' => 'nullable|string|max:255',
            'Impreso_Presentable' => 'nullable|string|max:255',
            'DigitalLocal' => 'nullable|file',
            'ImpresoPresentableLocal' => 'nullable|file', // Nuevo campo para archivos locales de "Impreso Presentable"
        ]);

        // Obtener la última ruta registrada desde la base de datos
        $ultimaRuta = RutaLocal::orderBy('created_at', 'desc')->first();


        //Cambiar la validacion para que se pueda subir otro archivo en dado caso de que ya se cuente con un subcurso creado 
        //Solo se usaria si en dado caso que ya tengan el archivo subido y quieran cambiarlo
        if (!$ultimaRuta || empty($ultimaRuta->rutacompleta)) {
            return redirect()->back()->with('error', 'Error: No se ha configurado la ruta de archivos.'); 
        }

        // Normalizar la ruta base
        $rutaBase = rtrim(str_replace('\\', '/', $ultimaRuta->rutacompleta), '/');

        // Crear las carpetas principales si no existen
        $carpetas = [
            '2- Material de Apoyo (Digital)',
            '8- Curso en Linea',
        ];

        $rutasActualizadas = [];

        foreach ($carpetas as $carpeta) {
            $rutaCompleta = $rutaBase . DIRECTORY_SEPARATOR . $carpeta;

            if (!File::exists($rutaCompleta)) {
                File::makeDirectory($rutaCompleta, 0755, true);
                Log::info("Carpeta creada: {$rutaCompleta}");
            } else {
                Log::info("Carpeta ya existe: {$rutaCompleta}");
            }

            // Guardar las rutas en el array de actualización
            switch ($carpeta) {
                case '2- Material de Apoyo (Digital)':
                    $rutasActualizadas['rutaMaterialdeapoyo'] = $rutaCompleta;
                    break;
                case '8- Curso en Linea':
                    $rutasActualizadas['rutacursoenlinea'] = $rutaCompleta;
                    break;
            }
        }

        // Actualizar la base de datos con las nuevas rutas
        $ultimaRuta->update($rutasActualizadas);

        // Procesar archivos locales
        $rutasArchivos = [];

        if ($request->hasFile('DigitalLocal')) {
            $archivo = $request->file('DigitalLocal');
            $nombreArchivo = time() . '_digital_' . $archivo->getClientOriginalName();
            $archivo->move($rutasActualizadas['rutaMaterialdeapoyo'], $nombreArchivo);
            $rutasArchivos['DigitalLocal'] = '2- Material de Apoyo (Digital)/' . $nombreArchivo;
        }

        if ($request->hasFile('ImpresoPresentableLocal')) {
            $archivo = $request->file('ImpresoPresentableLocal');
            $nombreArchivo = time() . '_impreso_presentable_' . $archivo->getClientOriginalName();
            $archivo->move($rutasActualizadas['rutacursoenlinea'], $nombreArchivo);
            $rutasArchivos['ImpresoPresentableLocal'] = '8- Curso en Linea/' . $nombreArchivo;
        }

        // Guardar los datos del Paso 5 en sesión
        session(['cursos_paso5' => array_merge($validated, $rutasArchivos)]);

        return redirect()->route('curso.paso6')->with('success', 'Carpetas creadas y archivos guardados correctamente.');

    } catch (\Exception $e) {
        Log::error("Error al procesar los archivos: " . $e->getMessage());
        return back()
            ->withInput()
            ->with('error', 'Error al procesar los archivos: ' . $e->getMessage());
    }
}

    // Mostrar el formulario del Paso 6
    public function mostrarPaso6()
{



    $cursoId = session('curso_id');
    $curso = Cursos::find($cursoId);

    // Buscar el curso padre si existe
    $datosPadre = null;
    if ($curso && $curso->parent_id) {
        $datosPadre = Cursos::find($curso->parent_id);
    }

    // Buscar la ruta del curso en la base de datos
    $rutaCurso = RutaLocal::where('id_cursos', $cursoId)->first();

    // Archivos que esperamos para este paso
    $archivosLocales = [
        'presentacion' => null,
        'EvaluacionDiagnosticaLocal' => null,
        'EvaluacionSatisfaccionLocal' => null,
        'EvaluacionFinalLocal' => null,
    ];

    // Verificamos si cada archivo tiene ruta asociada en la base de datos
    if ($rutaCurso) {
        foreach ($archivosLocales as $tipo => &$valor) {
            $campo = 'ruta' . str_replace('Local', '', $tipo); // ej. PresentacionLocal → rutaPresentacion
            if (!empty($rutaCurso->$campo)) {
                $valor = 'actual';
            } else {
                $valor = null;
            }
        }
        unset($valor);
    }

    return view('cursos.paso6', compact('curso', 'archivosLocales', 'datosPadre'));
}


    // Guardar los datos del Paso 6 y redirigir al siguiente paso
    public function guardarPaso6(Request $request)
{
    try {
        // 1. Validar los datos del formulario
        $validated = $request->validate([
            'Presentación' => 'nullable|string|max:255',
            'Evaluación_diagnostica' => 'nullable|string|max:255',
            'EvaluaciondeSatisfacción' => 'nullable|string|max:255',
            'EvaluacionFinal' => 'nullable|string|max:255',
            'PresentacionLocal' => 'nullable|file',
            'EvaluacionDiagnosticaLocal' => 'nullable|file',
            'EvaluacionSatisfaccionLocal' => 'nullable|file',
            'EvaluacionFinalLocal' => 'nullable|file',
            'DC3' => 'nullable|string|max:255',
        ]);

        // Obtener la última ruta registrada desde la base de datos
        $ultimaRuta = RutaLocal::orderBy('created_at', 'desc')->first();
        Log::info("Obteniendo última ruta: " . ($ultimaRuta ? "ID: {$ultimaRuta->id}" : "No encontrada"));

        if (!$ultimaRuta || empty($ultimaRuta->rutacompleta)) {
            Log::error("No se encontró una ruta válida en la base de datos o rutacompleta está vacía");
            return redirect()->back()->with('error', 'Error: No se ha configurado la ruta de archivos.');
        }

        // Normalizar la ruta base
        $rutaBase = str_replace('\\', '/', $ultimaRuta->rutacompleta);
        Log::info("Ruta base normalizada: {$rutaBase}");

        // Verificar que la ruta base existe
        if (!File::exists($rutaBase)) {
            Log::error("La ruta base no existe: {$rutaBase}");
            File::makeDirectory($rutaBase, 0755, true);
            Log::info("Carpeta base creada: {$rutaBase}");
        }

        // 3. Crear la carpeta "5- Evaluaciones" si no existe
        $rutaEvaluaciones = $rutaBase . '/5- Evaluaciones';
        Log::info("Intentando crear carpeta de evaluaciones: {$rutaEvaluaciones}");

        try {
            if (!File::exists($rutaEvaluaciones)) {
                File::makeDirectory($rutaEvaluaciones, 0755, true);
                Log::info("Carpeta de evaluaciones creada: {$rutaEvaluaciones}");
            } else {
                Log::info("Carpeta de evaluaciones ya existe: {$rutaEvaluaciones}");
            }
        } catch (\Exception $e) {
            Log::error("Error al crear carpeta de evaluaciones: " . $e->getMessage());
        }

        // 4. Crear la carpeta "4- Presentacion" si no existe
        $rutaPresentacion = $rutaBase . '/4- Presentacion';
        Log::info("Intentando crear carpeta de presentación: {$rutaPresentacion}");

        try {
            if (!File::exists($rutaPresentacion)) {
                File::makeDirectory($rutaPresentacion, 0755, true);
                Log::info("Carpeta de presentación creada: {$rutaPresentacion}");
            } else {
                Log::info("Carpeta de presentación ya existe: {$rutaPresentacion}");
            }
        } catch (\Exception $e) {
            Log::error("Error al crear carpeta de presentación: " . $e->getMessage());
        }

        // Guardar las rutas en la base de datos
        try {
            Log::info("Intentando actualizar las rutas en la base de datos para ID: {$ultimaRuta->id}");

            // Actualizar todas las rutas de una vez para evitar múltiples consultas
            $datosActualizar = [
                'rutaevaluaciones' => $rutaEvaluaciones,
                'rutapresentacion' => $rutaPresentacion
            ];

            $actualizado = $ultimaRuta->update($datosActualizar);

            if ($actualizado) {
                Log::info("Rutas actualizadas correctamente en la base de datos");
            } else {
                Log::error("No se pudieron actualizar las rutas en la base de datos");
            }
        } catch (\Exception $e) {
            Log::error("Error al actualizar rutas en la base de datos: " . $e->getMessage());
        }

        // 5. Procesar archivos locales (si existen)
        $rutasArchivos = [];

        // Procesar archivo PresentacionLocal
        if ($request->hasFile('PresentacionLocal')) {
            try {
                $archivo = $request->file('PresentacionLocal');
                $nombreArchivo = time() . '_presentacion_' . $archivo->getClientOriginalName();
                $archivo->move($rutaPresentacion, $nombreArchivo);
                $rutasArchivos['PresentacionLocal'] = '4- Presentacion/' . $nombreArchivo;
                Log::info("Archivo de presentación subido: {$rutaPresentacion}/{$nombreArchivo}");
            } catch (\Exception $e) {
                Log::error("Error al procesar archivo de presentación: " . $e->getMessage());
            }
        }

        // Procesar archivo EvaluacionDiagnosticaLocal
        if ($request->hasFile('EvaluacionDiagnosticaLocal')) {
            try {
                $archivo = $request->file('EvaluacionDiagnosticaLocal');
                $nombreArchivo = time() . '_evaluacion_diagnostica_' . $archivo->getClientOriginalName();
                $rutaCarpeta = $rutaEvaluaciones . '/EvaluacionDiagnostica';

                if (!File::exists($rutaCarpeta)) {
                    File::makeDirectory($rutaCarpeta, 0755, true);
                    Log::info("Carpeta de evaluación diagnóstica creada: {$rutaCarpeta}");
                }

                $archivo->move($rutaCarpeta, $nombreArchivo);
                $rutasArchivos['EvaluacionDiagnosticaLocal'] = '5- Evaluaciones/EvaluacionDiagnostica/' . $nombreArchivo;
                Log::info("Archivo de evaluación diagnóstica subido: {$rutaCarpeta}/{$nombreArchivo}");

                // Actualizar ruta específica
                $ultimaRuta->rutaEvaluacionDiagnostica = $rutaCarpeta;
                $ultimaRuta->save();
            } catch (\Exception $e) {
                Log::error("Error al procesar archivo de evaluación diagnóstica: " . $e->getMessage());
            }
        }

        // Procesar archivo EvaluacionSatisfaccionLocal
        if ($request->hasFile('EvaluacionSatisfaccionLocal')) {
            try {
                $archivo = $request->file('EvaluacionSatisfaccionLocal');
                $nombreArchivo = time() . '_evaluacion_satisfaccion_' . $archivo->getClientOriginalName();
                $rutaCarpeta = $rutaEvaluaciones . '/EvaluacionSatisfaccion';

                if (!File::exists($rutaCarpeta)) {
                    File::makeDirectory($rutaCarpeta, 0755, true);
                    Log::info("Carpeta de evaluación de satisfacción creada: {$rutaCarpeta}");
                }

                $archivo->move($rutaCarpeta, $nombreArchivo);
                $rutasArchivos['EvaluacionSatisfaccionLocal'] = '5- Evaluaciones/EvaluacionSatisfaccion/' . $nombreArchivo;
                Log::info("Archivo de evaluación de satisfacción subido: {$rutaCarpeta}/{$nombreArchivo}");

                // Actualizar ruta específica
                $ultimaRuta->rutaEvaluacionSatisfaccion = $rutaCarpeta;
                $ultimaRuta->save();
            } catch (\Exception $e) {
                Log::error("Error al procesar archivo de evaluación de satisfacción: " . $e->getMessage());
            }
        }

        // Procesar archivo EvaluacionFinalLocal
        if ($request->hasFile('EvaluacionFinalLocal')) {
            try {
                $archivo = $request->file('EvaluacionFinalLocal');
                $nombreArchivo = time() . '_evaluacion_final_' . $archivo->getClientOriginalName();
                $rutaCarpeta = $rutaEvaluaciones . '/EvaluacionFinal';

                if (!File::exists($rutaCarpeta)) {
                    File::makeDirectory($rutaCarpeta, 0755, true);
                    Log::info("Carpeta de evaluación final creada: {$rutaCarpeta}");
                }

                $archivo->move($rutaCarpeta, $nombreArchivo);
                $rutasArchivos['EvaluacionFinalLocal'] = '5- Evaluaciones/EvaluacionFinal/' . $nombreArchivo;
                Log::info("Archivo de evaluación final subido: {$rutaCarpeta}/{$nombreArchivo}");

                // Actualizar ruta específica
                $ultimaRuta->rutaEvaluacionFinal = $rutaCarpeta;
                $ultimaRuta->save();
            } catch (\Exception $e) {
                Log::error("Error al procesar archivo de evaluación final: " . $e->getMessage());
            }
        }

        // 6. Guardar las rutas principales en el array de datos para la sesión
        $rutasArchivos['rutaEvaluaciones'] = '5- Evaluaciones';
        $rutasArchivos['rutaPresentacion'] = '4- Presentacion';

        // 7. Guardar los datos del Paso 6 en sesión
        session(['cursos_paso6' => array_merge($validated, $rutasArchivos)]);
        Log::info("Datos guardados en sesión para el paso 6");

        // 8. Redirigir al siguiente paso
        Log::info("Redirigiendo al paso 7");
        return redirect()->route('curso.paso7')->with('success', 'Carpetas creadas y archivos guardados correctamente.');
    } catch (\Exception $e) {
        // Manejar errores y redirigir con un mensaje de error
        Log::error("Error general en guardarPaso6: " . $e->getMessage() . "\n" . $e->getTraceAsString());
        return back()
            ->withInput()
            ->with('error', 'Error al guardar los datos del Paso 6: ' . $e->getMessage());
    }
}

    // Mostrar el formulario del Paso 7
  public function mostrarPaso7()
{
    $cursoId = session('curso_id');
    $curso = Cursos::find($cursoId);

    // Buscar el curso padre si existe
    $datosPadre = null;
    if ($curso && $curso->parent_id) {
        $datosPadre = Cursos::find($curso->parent_id);
    }

    // Buscar la ruta del curso en la base de datos
    $rutaCurso = RutaLocal::where('id_cursos', $cursoId)->first();

    // Archivos esperados para el paso 7
    $archivosLocales = [
        'DC5' => null,
        'Formato_DC5' => null,
        'CertificadoComprobacion' => null,
        'cartapoder' => null,
        'Udemy' => null,
    ];

    // Verificamos si cada archivo tiene ruta asociada en la base de datos
    if ($rutaCurso) {
        foreach ($archivosLocales as $tipo => &$valor) {
            $campo = 'ruta' . $tipo; // ej. rutaDC5, rutaUdemy
            if (!empty($rutaCurso->$campo)) {
                $valor = 'actual';
            } else {
                $valor = null;
            }
        }
        unset($valor);
    }

    return view('cursos.paso7', compact('curso', 'archivosLocales', 'datosPadre'));
}


    // Guardar los datos del Paso 7 y finalizar
    public function guardarPaso7(Request $request)
    {
        try {
            // Validar los datos del paso 7
            $validatedPaso7 = $request->validate([
                'FechadeRegistro_STPS' => 'nullable|date',
                'Formato_DC5' => 'nullable|string|max:255',
                'Formato_DC5_Tienefirma' => 'nullable|string|in:Si,No',
                'Certificadodecomprobacion' => 'nullable|string|max:255',
                'DrivedeCertificadodecomprobacion' => 'nullable|string|max:255',
                'Cartapoder_tienefirma' => 'nullable|string|in:Si,No',
                'DriveCartapoder' => 'nullable|string|max:255',
                'UDEMY' => 'nullable|string|max:255',
                'FormatoDC5Local' => 'nullable|file',
                'CertificadoComprobacionLocal' => 'nullable|file',
                'CartaPoderLocal' => 'nullable|file',
                'UdemyLocal' => 'nullable|file', // Corregido de 'UDEMYLocal' a 'UdemyLocal' para que coincida con el HTML
            ]);
            // Obtener el ID del curso de la sesión
            $cursoId = session('curso_id');

            // Verificar que el ID del curso existe en la sesión
            if (!$cursoId) {
                Log::error('No se encontró el ID del curso en la sesión durante paso7');
                return redirect()->route('cursos.index')
                    ->with('error', 'Error al procesar el curso. Por favor, inicie nuevamente.');
            }

            // Obtener el curso existente basado en el ID de la sesión
            $curso = Cursos::find($cursoId);

            if (!$curso) {
                Log::error('No se encontró el curso con ID ' . $cursoId . ' en la base de datos');
                return redirect()->route('cursos.index')
                    ->with('error', 'El curso no existe en la base de datos. Por favor, inicie nuevamente.');
            }

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

            // Obtener la última ruta base desde la base de datos
            $ultimaRuta = RutaLocal::orderBy('created_at', 'desc')->first();

            // Corrección 3: Verificar rutacompleta en lugar de ruta_base
            if (!$ultimaRuta || !$ultimaRuta->rutacompleta) {
                return back()
                    ->withInput()
                    ->with('error', 'Error: No se ha configurado la ruta de archivos.');
            }
            // Verificar que la ruta corresponde al mismo curso
            if ($ultimaRuta->id_cursos != $cursoId) {
                Log::warning('La ruta local más reciente no coincide con el curso actual', [
                    'ruta_curso_id' => $ultimaRuta->id_cursos,
                    'sesion_curso_id' => $cursoId
                ]);

                // Actualizar la ruta con el ID correcto
                $ultimaRuta->update([
                    'id_cursos' => $cursoId
                ]);

                Log::info('Ruta local actualizada para coincidir con el curso actual', [
                    'ruta_id' => $ultimaRuta->id,
                    'curso_id' => $cursoId
                ]);
            }

            $rutaBase = rtrim(str_replace('\\', '/', $ultimaRuta->rutacompleta), '/');

            // Crear la carpeta principal "0- DC5" si no existe
            $rutaDC5 = $rutaBase . '/0- DC5';
            if (!File::exists($rutaDC5)) {
                File::makeDirectory($rutaDC5, 0755, true);
                Log::info("La carpeta '0- DC5' ha sido creada en la ruta base.");
            }

            // Crear subcarpetas dentro de "0- DC5"
            $subcarpetas = [
                'CertificadoComprobacion',
                'FormatoDC5',
                'CartaPoder',
                'UDEMY'
            ];

            $rutasArchivos = [];

            foreach ($subcarpetas as $carpeta) {
                $rutaCarpeta = $rutaDC5 . '/' . $carpeta;
                if (!File::exists($rutaCarpeta)) {
                    File::makeDirectory($rutaCarpeta, 0755, true);
                    Log::info("La carpeta '$carpeta' ha sido creada dentro de '0- DC5'.");
                }
            }

            // Guardar archivos locales en sus respectivas carpetas
            if ($request->hasFile('FormatoDC5Local')) {
                $archivo = $request->file('FormatoDC5Local');
                $nombreArchivo = time() . '_formatodc5_' . $archivo->getClientOriginalName();
                $archivo->move($rutaDC5 . '/formatoDC5', $nombreArchivo);
                $rutasArchivos['rutacarpetaDC5'] = '0- DC5/FormatoDC5/' . $nombreArchivo;
            }

            if ($request->hasFile('CertificadoComprobacionLocal')) {
                $archivo = $request->file('CertificadoComprobacionLocal');
                $nombreArchivo = time() . '_certificadocomprobacion_' . $archivo->getClientOriginalName();
                $archivo->move($rutaDC5 . '/CertificadoComprobacion', $nombreArchivo);
                $rutasArchivos['rutaCertificadoComprobacion'] = '0- DC5/CertificadoComprobacion/' . $nombreArchivo;
            }

            if ($request->hasFile('CartaPoderLocal')) {
                $archivo = $request->file('CartaPoderLocal');
                $nombreArchivo = time() . '_cartapoder_' . $archivo->getClientOriginalName();
                $archivo->move($rutaDC5 . '/CartaPoder', $nombreArchivo);
                $rutasArchivos['rutacartapoder'] = '0- DC5/CartaPoder/' . $nombreArchivo;
            }

            // Corrección 2: Asegúrate de usar 'UdemyLocal' coherentemente como en el HTML
            if ($request->hasFile('UdemyLocal')) {
                $archivo = $request->file('UdemyLocal');
                $nombreArchivo = time() . '_udemy_' . $archivo->getClientOriginalName();
                $archivo->move($rutaDC5 . '/UDEMY', $nombreArchivo);
                $rutasArchivos['rutaUdemy'] = '0- DC5/UDEMY/' . $nombreArchivo;
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

             // IMPORTANTE: Ya no verificamos si existe curso_id, siempre actualizamos el curso existente
                $curso->update($cursoData);

                Log::info('Curso actualizado exitosamente', ['curso_id' => $curso->id]);

            // Registrar la acción de creación (asegúrate de que este código solo se ejecute si el curso es nuevo)
           CourseActionLog::create([
                'curso_id' => $curso->id,
                'nombre_curso' => $curso->NombredelCurso,
                'user_id' => Auth::id(),
                'accion' => 'Finalizado',
                'detalles' => 'Paso 7 completado. Curso guardado por el usuario.',
                'fecha_accion' => now(),
            ]);

            // Limpiar los datos de la sesión
            session()->forget([
                'cursos_paso1',
                'cursos_paso2',
                'cursos_paso3',
                'cursos_paso4',
                'cursos_paso5',
                'cursos_paso6',
                'curso_id'
            ]);

            // Redireccionar al index con mensaje de éxito
            return redirect()->route('cursos.index')
                ->with('success', 'Curso creado exitosamente');

        } catch (\Exception $e) {
            Log::error('Error al finalizar curso: ' . $e->getMessage(), [
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
                        'Nomenclatura' => 'nullable|string|max:255',
                        'NombredelCurso' => 'nullable|string|max:255',
                        'DescripciondeCurso' => 'nullable|string',
                        'CostodelCurso' => 'nullable|numeric',
                        'InstructorResponsable' => 'nullable|string|max:255',
                        'FechadeInicio' => 'nullable|date',
                        'FechadeTermino' => 'nullable|date|after_or_equal:FechadeInicio',
                        'Duracioncurso' => 'nullable|string|max:100',
                    ]);
                    break;
                case 2:
                    $validated = $request->validate([
                        'Virtual' => 'nullable|in:Si,No',
                        'Presencial' => 'nullable|in:Si,No',
                        'Mixto' => 'nullable|in:Si,No',
                    ]);
                    break;
                case 3:
                    $validated = $request->validate([
                        'SinFecha' => 'nullable|string|max:255',
                        'DriveSinFecha' => 'nullable|string|max:255',
                        'Facebook' => 'nullable|string|max:255',
                        'DriveFacebook' => 'nullable|string|max:255',
                        'Linkedin' => 'nullable|string|max:255',
                        'DriveLinkedin' => 'nullable|string|max:255',
                        'Instagram' => 'nullable|string|max:255',
                        'DriveInstagram' => 'nullable|string|max:255',
                    ]);
                    break;
                case 4:
                    $validated = $request->validate([
                        'Temario' => 'nullable|string|max:255',
                        'DriveTemario' => 'nullable|string|max:255',
                        'Itinerario' => 'nullable|string|max:255',
                        'DriveItinerario' => 'nullable|string|max:255',
                        'Planeación' => 'nullable|string|max:255',
                        'DrivePlaneación' => 'nullable|string|max:255',
                    ]);
                    break;
                case 5:
                    $validated = $request->validate([
                        'Digital' => 'nullable|string|max:255',
                        'DriveDigital' => 'nullable|string|max:255',
                        'Impreso_Presentable' => 'nullable|string|max:255',
                    ]);
                    break;
                case 6:
                    $validated = $request->validate([
                        'Presentación' => 'nullable|string|max:255',
                        'Evaluación_diagnostica' => 'nullable|string|max:255',
                        'EvaluaciondeSatisfacción' => 'nullable|string|max:255',
                        'EvaluacionFinal' => 'nullable|string|max:255',
                        'DC3' => 'nullable|string|in:Tiene DC3,No tiene DC3,Por confirmar',
                    ]);
                    break;
                case 7:
                    $validated = $request->validate([
                        'FechadeRegistro_STPS' => 'nullable|date',
                        'Formato_DC5' => 'nullable|string|max:255',
                        'Formato_DC5_Tienefirma' => 'nullable|string|in:Si,No',
                        'Certificadodecomprobacion' => 'nullable|string|max:255',
                        'DrivedeCertificadodecomprobacion' => 'nullable|string|max:255',
                        'Cartapoder_tienefirma' => 'nullable|string|in:Si,No',
                        'DriveCartapoder' => 'nullable|string|max:255',
                        'UDEMY' => 'nullable|string|max:255',
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


    //Calcular los pasos y mostrar por colores los diferentes estados de los pasos
    private function calcularProgresoPaso(Cursos $curso): array
{
    $progreso = [];

    $pasosCampos = [
        1 => ['Nomenclatura', 'NombredelCurso', 'DescripciondeCurso', 'CostodelCurso', 'InstructorResponsable', 'FechadeInicio', 'FechadeTermino', 'Duracioncurso'],
        2 => ['Virtual', 'Presencial', 'Mixto'],
        3 => ['SinFecha', 'DriveSinFecha', 'Facebook', 'DriveFacebook', 'Linkedin', 'DriveLinkedin', 'Instagram', 'DriveInstagram'],
        4 => ['Temario', 'DriveTemario', 'Itinerario', 'DriveItinerario', 'Planeación', 'DrivePlaneación'],
        5 => ['Digital', 'DriveDigital', 'Impreso_Presentable'],
        6 => ['Presentación', 'Evaluación_diagnostica', 'EvaluaciondeSatisfacción', 'EvaluacionFinal', 'DC3'],
        7 => ['FechadeRegistro_STPS', 'Formato_DC5', 'Formato_DC5_Tienefirma', 'Certificadodecomprobacion', 'DrivedeCertificadodecomprobacion', 'Cartapoder_tienefirma', 'DriveCartapoder', 'UDEMY'],
    ];

    foreach ($pasosCampos as $paso => $campos) {
        $llenos = 0;
        foreach ($campos as $campo) {
            if (!empty($curso->$campo)) {
                $llenos++;
            }
        }

        $total = count($campos);
        $porcentaje = $total > 0 ? ($llenos / $total) * 100 : 0;

        // Asignar color según porcentaje
        if ($porcentaje >= 80) {
            $progreso[$paso] = 'btn-success'; // Verde
        } elseif ($porcentaje >= 50) {
            $progreso[$paso] = 'btn-warning'; // Amarillo
        } else {
            $progreso[$paso] = 'btn-danger'; // Rojo
        }
    }

    return $progreso;
}
//aqui termina 

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
            'tipo' => 'required|string', // Tipo de carpeta: SinFecha, Facebook, LinkedIn, Instagram, etc.
        ]);

        // Obtener la última ruta registrada desde la base de datos
        $ultimaRuta = RutaLocal::orderBy('id', 'desc')->first();

        if (!$ultimaRuta || !$ultimaRuta->rutacompleta) {
            return response()->json([
                'success' => false,
                'message' => 'Error: No se ha configurado la ruta de archivos.'
            ], 400);
        }

        // Normalizar la ruta base
        $rutaBase = rtrim(str_replace('\\', '/', $ultimaRuta->rutacompleta), '/');

        // Determinar si es una carpeta relacionada con Flyers
        $esCarpetaFlyer = in_array($request->tipo, ['SinFecha', 'Facebook', 'LinkedIn', 'Instagram']);
        $rutaPrincipalFlyers = $esCarpetaFlyer ? $rutaBase . '/Flyers' : $rutaBase;

        // Determinar si es una carpeta relacionada con Evaluaciones
        $esCarpetaEvaluaciones = in_array($request->tipo, ['EvaluacionDiagnostica', 'EvaluacionSatisfaccion', 'EvaluacionFinal']);
        $rutaPrincipalEvaluaciones = $esCarpetaEvaluaciones ? $rutaBase . '/5- Evaluaciones' : $rutaBase;

        // Corrección: Asegúrate de usar 'FormatoDC5' como un tipo válido para DC5
        $esCarpetaDC5 = in_array($request->tipo, ['FormatoDC5', 'CertificadoComprobacion', 'CartaPoder', 'Udemy']);
        $rutaPrincipalDC5 = $esCarpetaDC5 ? $rutaBase . '/0- DC5' : $rutaBase;

        // Crear la carpeta principal ("Flyers", "5- Evaluaciones" o "0- DC5") si no existe
        if ($esCarpetaFlyer && !File::exists($rutaPrincipalFlyers)) {
            File::makeDirectory($rutaPrincipalFlyers, 0755, true);
        }

        if ($esCarpetaEvaluaciones && !File::exists($rutaPrincipalEvaluaciones)) {
            File::makeDirectory($rutaPrincipalEvaluaciones, 0755, true);
        }

        if ($esCarpetaDC5 && !File::exists($rutaPrincipalDC5)) {
            File::makeDirectory($rutaPrincipalDC5, 0755, true);
        }

        // Mapear los tipos a nombres específicos de carpetas
        $nombresCarpetas = [
            'SinFecha' => 'SinFecha',
            'Facebook' => 'Facebook',
            'LinkedIn' => 'LinkedIn',
            'Instagram' => 'Instagram',
            'Temario' => '1-Temario',
            'Itinerario' => '6-Itinerario',
            'Planeación' => '3-Planeación',
            'Digital' => '2- Material de Apoyo (Digital)',
            'ImpresoPresentable' => '8- Curso en Linea',
            'EvaluacionDiagnostica' => 'EvaluacionDiagnostica',
            'EvaluacionSatisfaccion' => 'EvaluacionSatisfaccion',
            'EvaluacionFinal' => 'EvaluacionFinal',
            'Presentacion' => '4- Presentacion',
            'FormatoDC5' => 'FormatoDC5',
            'CertificadoComprobacion' => 'CertificadoComprobacion',
            'CartaPoder' => 'CartaPoder',
            'Udemy' => 'UDEMY', // Corrección: 'Udemy' de la solicitud mapea a 'UDEMY' en la carpeta
        ];

        // Obtener el nombre de la carpeta según el tipo
        $nombreCarpeta = $nombresCarpetas[$request->tipo] ?? ucfirst($request->tipo);

        // Construir la ruta completa
        $rutaCompleta = ($esCarpetaFlyer ? $rutaPrincipalFlyers :
                        ($esCarpetaEvaluaciones ? $rutaPrincipalEvaluaciones :
                        ($esCarpetaDC5 ? $rutaPrincipalDC5 : $rutaBase))) . '/' . $nombreCarpeta;

        // Verificar si la carpeta ya existe
        if (File::exists($rutaCompleta)) {
            // Ya existe, no es un error; solo responde como éxito
            return response()->json([
                'success' => true,
                'message' => 'La carpeta ya existe y puede ser utilizada.'
            ], 200);
        }


        // Crear la carpeta
        File::makeDirectory($rutaCompleta, 0755, true);

        // Guardar la ruta en la columna correspondiente
        $datosActualizar = [];

        switch ($request->tipo) {
            case 'SinFecha':
            case 'Facebook':
            case 'LinkedIn':
            case 'Instagram':
                $datosActualizar['rutaformatosflyer'] = $rutaPrincipalFlyers; // Guardar la ruta de la carpeta principal "Flyers"
                $datosActualizar['ruta' . $request->tipo] = $rutaCompleta; // Guardar la ruta específica
                break;

            case 'Temario':
                $datosActualizar['rutaTemario'] = $rutaCompleta;
                break;

            case 'Itinerario':
                $datosActualizar['rutaItinerario'] = $rutaCompleta;
                break;

            case 'Planeación':
                $datosActualizar['rutaPlaneacion'] = $rutaCompleta;
                break;

            case 'Digital':
                $datosActualizar['rutaMaterialdeapoyo'] = $rutaCompleta; // Guardar la ruta de "2- Material de Apoyo (Digital)"
                break;

            case 'ImpresoPresentable':
                $datosActualizar['rutacursoenlinea'] = $rutaCompleta; // Guardar la ruta de "8- Curso en Linea"
                break;

            case 'Presentacion':
                $datosActualizar['rutaPresentacion'] = $rutaCompleta; // Guardar la ruta de "4- Presentacion"
                break;

            case 'EvaluacionDiagnostica':
            case 'EvaluacionSatisfaccion':
            case 'EvaluacionFinal':
                $datosActualizar['rutaEvaluaciones'] = $rutaPrincipalEvaluaciones; // Guardar la ruta de la carpeta principal "5- Evaluaciones"
                $datosActualizar['ruta' . $request->tipo] = $rutaCompleta; // Guardar la ruta específica
                break;

            case 'FormatoDC5':
                $datosActualizar['rutaDC5'] = $rutaPrincipalDC5; // Guardar la ruta de la carpeta principal "0- DC5"
                $datosActualizar['rutaFormatoDC5'] = $rutaCompleta; // Guardar la ruta específica
                break;

            case 'CertificadoComprobacion':
                $datosActualizar['rutaDC5'] = $rutaPrincipalDC5; // Guardar la ruta de la carpeta principal "0- DC5"
                $datosActualizar['rutaCertificadoComprobacion'] = $rutaCompleta; // Guardar la ruta específica
                break;

            case 'CartaPoder':
                $datosActualizar['rutaDC5'] = $rutaPrincipalDC5; // Guardar la ruta de la carpeta principal "0- DC5"
                $datosActualizar['rutacartapoder'] = $rutaCompleta; // Guardar la ruta específica
                break;

            case 'Udemy':
                $datosActualizar['rutaDC5'] = $rutaPrincipalDC5; // Guardar la ruta de la carpeta principal "0- DC5"
                $datosActualizar['rutaUdemy'] = $rutaCompleta; // Guardar la ruta específica
                break;
        }

        // Actualizar la fila en la base de datos
        $ultimaRuta->update($datosActualizar);

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

            // Obtener la última ruta registrada desde la base de datos
            $ultimaRuta = RutaLocal::orderBy('id', 'desc')->first();

            if (!$ultimaRuta || !$ultimaRuta->rutacompleta) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error: No se ha configurado la ruta de archivos.'
                ], 400);
            }

            // Normalizar la ruta base
            $rutaBase = str_replace('\\', '/', $ultimaRuta->rutacompleta);
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

    public function finalizacionForzada(Request $request)
    {
        try {
            // Obtener los datos enviados desde el frontend
            $datos = $request->all();

            // Obtener el ID del curso de la sesión si existe
            $cursoId = session('curso_id');

            // Obtener los datos de todos los pasos almacenados en la sesión
            $paso1 = session('cursos_paso1', []);
            $paso2 = session('cursos_paso2', []);
            $paso3 = session('cursos_paso3', []);
            $paso4 = session('cursos_paso4', []);
            $paso5 = session('cursos_paso5', []);
            $paso6 = session('cursos_paso6', []);

            // Combinar todos los datos disponibles hasta este punto
            $cursoData = array_merge(
                $paso1,
                $paso2,
                $paso3,
                $paso4,
                $paso5,
                $paso6,
                $datos // Datos enviados desde el frontend
            );

            // Asignar valores predeterminados para campos adicionales
            $cursoData['status'] = 1; // Curso activo
            $cursoData['user_id'] = Auth::id(); // Usuario que crea el curso

            // Verificar si es actualización o creación
            if ($cursoId) {
                // Obtener el curso existente
                $curso = Cursos::find($cursoId);

                if (!$curso) {
                    Log::error('No se encontró el curso con ID ' . $cursoId . ' en la base de datos');
                    return response()->json([
                        'success' => false,
                        'message' => 'El curso no existe en la base de datos.'
                    ], 404);
                }

                // Actualizar el curso existente
                $curso->update($cursoData);

                Log::info('Curso actualizado exitosamente mediante finalización forzada', ['curso_id' => $curso->id]);

                $accion = 'Actualizado (Finalización Forzada)';
                $detalles = 'Curso actualizado mediante finalización forzada.';
            } else {
                // Crear un nuevo curso
                $curso = Cursos::create($cursoData);

                if (!$curso) {
                    throw new \Exception('No se pudo crear el curso');
                }

                Log::info('Curso creado exitosamente mediante finalización forzada', ['curso_id' => $curso->id]);

                $accion = 'Creado (Finalización Forzada)';
                $detalles = 'Curso creado mediante finalización forzada.';

                // Obtener la última ruta base desde la base de datos
                $ultimaRuta = RutaLocal::orderBy('created_at', 'desc')->first();

                // Si existe una ruta, asegúrate de que esté asociada al curso recién creado
                if ($ultimaRuta) {
                    $ultimaRuta->update([
                        'id_cursos' => $curso->id
                    ]);

                    Log::info('Ruta local actualizada para coincidir con el curso creado', [
                        'ruta_id' => $ultimaRuta->id,
                        'curso_id' => $curso->id
                    ]);
                }
            }

            // Registrar la acción
            CourseActionLog::create([
                'curso_id' => $curso->id,
                'nombre_curso' => $curso->NombredelCurso,
                'user_id' => Auth::id(),
                'accion' => $accion,
                'detalles' => $detalles,
                'fecha_accion' => now(),
            ]);

            // Limpiar los datos de la sesión
            session()->forget([
                'cursos_paso1',
                'cursos_paso2',
                'cursos_paso3',
                'cursos_paso4',
                'cursos_paso5',
                'cursos_paso6',
                'curso_id'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Curso guardado exitosamente.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error en finalización forzada: ' . $e->getMessage(), [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error al guardar el curso: ' . $e->getMessage()
            ], 500);
        }
    }

  public function iniciarCurso()
{
    try {
        Log::info('===> Entrando al método iniciarCurso');

        // Obtener la última ruta disponible sin asignar a un curso
        $ultimaRuta = RutaLocal::whereNull('id_cursos')
            ->orderBy('created_at', 'desc')
            ->first();

        // Si no hay ruta disponible, regresar
        if (!$ultimaRuta) {
            Log::warning('No se ha configurado ninguna ruta disponible.');
            return redirect()->back()->with('error', 'Error: No hay una ruta disponible para crear un curso. Por favor, configura una nueva ruta.');
        }

        // Verificar que NO haya otra ruta con el mismo nombre de carpeta (evitar conflicto)
        $carpetaDuplicada = RutaLocal::where('nombre_carpeta', $ultimaRuta->nombre_carpeta)
            ->whereNotNull('id_cursos')
            ->exists();

        if ($carpetaDuplicada) {
            Log::warning('Ya existe una carpeta con ese nombre asignada a otro curso: ' . $ultimaRuta->nombre_carpeta);
            return redirect()->back()->with('error', 'Ya existe una carpeta con el nombre "' . $ultimaRuta->nombre_carpeta . '". Por favor, cambia el nombre de la carpeta.');
        }

        // Crear curso
        $curso = Cursos::create([
            'NombredelCurso' => $ultimaRuta->nombre_carpeta,
            'status' => 1,
        ]);

        // Crear carpeta física (si aplica)
        $rutaBase = rtrim($ultimaRuta->rutacompleta, '/');
        $rutaCarpeta = $rutaBase . DIRECTORY_SEPARATOR . 'Curso_' . $curso->id;
        // Puedes usar File::makeDirectory($rutaCarpeta); si quieres crear la carpeta

        // Asociar la ruta con el curso recién creado
        $ultimaRuta->update([
            'id_cursos' => $curso->id,
        ]);

        // Guardar ID en sesión
        session(['curso_id' => $curso->id]);
        Log::info('Curso creado con ID: ' . $curso->id);
        session()->forget('nomenclatura_generada');
        return redirect()->route('curso.paso1')->with('success', 'Curso iniciado exitosamente.');
    } catch (\Exception $e) {
        Log::error('Error al iniciar el curso: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Error al iniciar el curso: ' . $e->getMessage());
    }
}



//Se remplazo por el método iniciarCursos
// public function iniciarSubcurso($idCursoPadre)
// {
//     try {
//         // 1. Obtener curso padre
//         $cursoPadre = Cursos::findOrFail($idCursoPadre);

//         // 2. Obtener la ruta del curso padre
//         $rutaPadre = RutaLocal::where('id_cursos', $cursoPadre->id)->first();

//         if (!$rutaPadre) {
//             return redirect()->back()->with('error', 'No se encontró la ruta del curso padre.');
//         }

//         // 3. Contar subcursos ya existentes del mismo padre
//         $numSubcursos = Cursos::where('parent_id', $cursoPadre->id)->count();
//         $numeroNuevo = $numSubcursos + 1;

//         // 4. Nombre del subcurso y subcarpeta
//         $nombreSubcurso = 'Subcurso_' . $cursoPadre->NombredelCurso . '_' . $numeroNuevo;
//         $rutaBase = rtrim($rutaPadre->rutacompleta, '/');
//         $rutaSubcarpeta = $rutaBase . DIRECTORY_SEPARATOR . $nombreSubcurso;

//         // 5. Crear carpeta física
//         if (!File::exists($rutaSubcarpeta)) {
//             File::makeDirectory($rutaSubcarpeta, 0755, true);
//         }

//         // 6. Crear subcurso en base de datos
//         $subcurso = Cursos::create([
//             'NombredelCurso' => $nombreSubcurso,
//             'status' => 0,
//             'parent_id' => $cursoPadre->id,
//         ]);

//         // 7. Registrar ruta local del subcurso
//         RutaLocal::create([
//             'nombre_carpeta' => $nombreSubcurso,
//             'rutacompleta' => $rutaSubcarpeta,
//             'id_cursos' => $subcurso->id,
//         ]);

//         // 8. Guardar en sesión y redirigir
//         session(['curso_id' => $subcurso->id]);

//         return redirect()->route('curso.paso1')->with('success', 'Subcurso creado y ruta asignada.');
//     } catch (\Exception $e) {
//         Log::error('Error al crear subcurso: ' . $e->getMessage());
//         return redirect()->back()->with('error', 'Error al crear subcurso.');
//     }
// }

//Funcion para obtener los subcursos de un curso padre
public function obtenerSubcursos($cursoId, Request $request)
{
    $query = Cursos::where('status', 1)
        ->where('parent_id', $cursoId);

    if ($request->filled('instructor')) {
        $query->where('InstructorResponsable', $request->instructor);
    }

    // Si necesitas el puesto del usuario autenticado para los botones:
    $puesto_usuario = \Illuminate\Support\Facades\Auth::user()->puesto ?? '';

    $subcursos = $query->get()->map(function($subcurso) use ($puesto_usuario) {
        $subcurso->puesto_usuario = $puesto_usuario;
        return $subcurso;
    });

    return response()->json($subcursos);
}


//Metodo que sirve para iniciar un subcurso creado desde un curso padre
//(paso 2 el paso  1 es cuando se crea la ruta de la carpeta en el metodo prepararRutaSubcurso)
 public function iniciarSubcursos($parent_id)
{
    try {
        Log::info('===> Entrando al método iniciarSubcursos');

        $ultimaRuta = RutaLocal::orderBy('created_at', 'desc')->first();
        if (!$ultimaRuta) {
            return redirect()->back()->with('error', 'Error: No se ha configurado ninguna ruta.');
        }

        $carpetaExistente = RutaLocal::where('nombre_carpeta', $ultimaRuta->nombre_carpeta)
            ->where('id', '!=', $ultimaRuta->id)
            ->exists();

        if ($carpetaExistente) {
            return redirect()->back()->with('error', 'Ya existe una carpeta con ese nombre. Cambie el nombre.');
        }

        // Crear el curso hijo
        $curso = Cursos::create([
            'NombredelCurso' => $ultimaRuta->nombre_carpeta,
            'status' => 0,
            'parent_id' => $parent_id, // Asociar con el curso padre
        ]);

        // Enlazar con ruta
        $ultimaRuta->update(['id_cursos' => $curso->id]);

        // Obtener nomenclatura del curso padre
        $cursoPadre = Cursos::find($parent_id);
        $nomenclaturaPadre = $cursoPadre->Nomenclatura ?? '000';
        $sufijo = explode('-', $nomenclaturaPadre);
        $codigo = count($sufijo) > 1 ? $sufijo[1] : $nomenclaturaPadre;

        // Contar subcursos actuales del padre
        $subcursosCount = Cursos::where('parent_id', $parent_id)->count();

        // Generar nomenclatura
        $anio = now()->format('y');
        $numero = str_pad($subcursosCount, 2, '0', STR_PAD_LEFT);
        $nomenclatura = "$anio-$codigo.$numero";

        // Guardar en sesión para mostrarlo en el formulario
        session([
            'curso_id' => $curso->id,
            'nomenclatura_generada' => $nomenclatura
        ]);

        return redirect()->route('curso.paso1')->with('success', 'Subcurso iniciado.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
    }
}


public function prepararRutaSubcurso(Request $request)
{
    try {
        $idPadre = $request->input('idCursoPadre');
        $nombreCursoPadre = $request->input('nombre_curso_padre');
        $rutaPadre = rtrim($request->input('ruta_nombre_carpeta'), DIRECTORY_SEPARATOR);

        // Buscar ruta padre desde base de datos
        $rutaPadreDB = RutaLocal::where('rutacompleta', $rutaPadre)->first();

        // Contar subcursos existentes
        $contador = Cursos::where('parent_id', $idPadre)->count() + 1;
        $nombreSubcarpeta = "Subcurso_{$nombreCursoPadre}_{$contador}";
        $rutaCompleta = $rutaPadre . DIRECTORY_SEPARATOR . $nombreSubcarpeta;

        // Crear carpeta principal del subcurso
        if (!File::exists($rutaCompleta)) {
            File::makeDirectory($rutaCompleta, 0775, true);
        }

        // Carpetas que se copiarán desde el curso padre (incluye '0- DC5')
        $carpetasACopiar = [
            '0- DC5',
            '1-Temario',
            '2- Material de Apoyo (Digital)',
            '3-Planeación',
            '4- Presentacion',
            '5- Evaluaciones',
            '6-Itinerario',
            '8- Curso en Linea'
        ];

        foreach ($carpetasACopiar as $carpeta) {
            $origen = $rutaPadre . DIRECTORY_SEPARATOR . $carpeta;
            $destino = $rutaCompleta . DIRECTORY_SEPARATOR . $carpeta;

            if (File::exists($origen)) {
                if (!File::exists($destino)) {
                    File::copyDirectory($origen, $destino);
                    Log::info("Copiada carpeta del curso padre: $carpeta");
                }
            } else {
                Log::warning("No se encontró la carpeta en el curso padre: $origen");
            }
        }

        // Subcarpetas dentro de 5- Evaluaciones
        $rutaEvaluaciones = $rutaCompleta . DIRECTORY_SEPARATOR . '5- Evaluaciones';
        $rutaEvaluacionDiagnostica = $rutaEvaluaciones . DIRECTORY_SEPARATOR . 'EvaluacionDiagnostica';
        $rutaEvaluacionSatisfaccion = $rutaEvaluaciones . DIRECTORY_SEPARATOR . 'EvaluacionSatisfaccion';
        $rutaEvaluacionFinal = $rutaEvaluaciones . DIRECTORY_SEPARATOR . 'EvaluacionFinal';

        foreach ([$rutaEvaluacionDiagnostica, $rutaEvaluacionSatisfaccion, $rutaEvaluacionFinal] as $rutaSub) {
            if (!File::exists($rutaSub)) {
                File::makeDirectory($rutaSub, 0775, true);
                Log::info("Subcarpeta creada: $rutaSub");
            }
        }

        // Ruta final de carpeta 8
        $rutaCursoEnLinea = $rutaCompleta . DIRECTORY_SEPARATOR . '8- Curso en Linea';

        // Rutas del curso padre para heredar
        $rutaDC5 = $rutaPadreDB->rutaDC5 ?? null;
        $rutacarpetaDC5 = $rutaPadreDB->rutacarpetaDC5 ?? null;
        $rutaCertificadoComprobacion = $rutaPadreDB->rutaCertificadoComprobacion ?? null;
        $rutacartapoder = $rutaPadreDB->rutacartapoder ?? null;
        $rutaUdemy = $rutaPadreDB->rutaUdemy ?? null;

        // Crear registro en base de datos
        $nuevaRuta = RutaLocal::create([
            'nombre_carpeta' => $nombreSubcarpeta,
            'ruta_nombre_carpeta' => $rutaPadre,
            'rutacompleta' => $rutaCompleta,
            'rutaTemario' => $rutaCompleta . DIRECTORY_SEPARATOR . '1-Temario',
            'rutaMaterialdeapoyo' => $rutaCompleta . DIRECTORY_SEPARATOR . '2- Material de Apoyo (Digital)',
            'rutaPlaneacion' => $rutaCompleta . DIRECTORY_SEPARATOR . '3-Planeación',
            'rutapresentacion' => $rutaCompleta . DIRECTORY_SEPARATOR . '4- Presentacion',
            'rutaevaluaciones' => $rutaEvaluaciones,
            'rutaItinerario' => $rutaCompleta . DIRECTORY_SEPARATOR . '6-Itinerario',
            'rutaEvaluacionDiagnostica' => $rutaEvaluacionDiagnostica,
            'rutaEvaluacionSatisfaccion' => $rutaEvaluacionSatisfaccion,
            'rutaEvaluacionFinal' => $rutaEvaluacionFinal,
            'rutacursoenlinea' => $rutaCursoEnLinea,
            'rutaDC5' => $rutaDC5,
            'rutacarpetaDC5' => $rutacarpetaDC5,
            'rutaCertificadoComprobacion' => $rutaCertificadoComprobacion,
            'rutacartapoder' => $rutacartapoder,
            'rutaUdemy' => $rutaUdemy,
            'id_cursos' => null,
        ]);

        return redirect()->route('subcursos.iniciar', ['id' => $idPadre]);

    } catch (\Exception $e) {
        Log::error('Error al preparar ruta del subcurso: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Error al preparar la ruta del subcurso.');
    }
}

public function rutas(){
    return view('cursos.ruta');
}

}
