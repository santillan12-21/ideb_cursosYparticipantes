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
use Illuminate\Support\Str;
use App\Models\Inscripcion;
use App\Models\Participantes;

class CursoController extends Controller
{
    /**
     * Mostrar la lista de cursos (activos e inactivos).
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $instructor = $request->get('instructor');

        // Mostramos los cursos principales (parent_id = null) que estén activos (1) o suspendidos (0)
        $query = Cursos::whereNull('parent_id')->whereIn('status', [0, 1]);

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('nomenclatura', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }

        if ($instructor) {
            $query->where('instructor_responsable', $instructor);
        }

        $cursos = $query->orderBy('created_at', 'desc')->paginate(5)->withQueryString();

        // Obtenemos todos los subcursos para el filtro de instructores (si se sigue necesitando en la vista)
        $subcursos = Cursos::whereNotNull('parent_id')->get(); 

        return view('cursos.index', compact('cursos', 'subcursos'));
    }

    public function obtenerSubcursos($cursoId, Request $request)
    {
        try {
            $subcursos = Cursos::where('parent_id', $cursoId)->get()->map(function($sub) {
                $modalidades = [];
                if ($sub->virtual == 1) $modalidades[] = 'Virtual';
                if ($sub->presencial == 1) $modalidades[] = 'Presencial';
                if ($sub->mixto == 1) $modalidades[] = 'Mixto';

                return [
                    'id' => $sub->id,
                    'nomenclatura' => $sub->nomenclatura,
                    'nombre' => $sub->nombre,
                    'instructor' => $sub->instructor_responsable,
                    'costo' => number_format((float)$sub->costo, 2),
                    'status' => $sub->status,
                    'modalidad' => !empty($modalidades) ? implode(', ', $modalidades) : 'N/A',
                ];
            });
            return response()->json($subcursos);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function papelera()
    {
        // Cursos en la papelera (status = 2)
        $cursos = Cursos::whereNull('parent_id')->where('status', 2)->orderBy('updated_at', 'desc')->get();
        return view('cursos.papelera', compact('cursos'));
    }

    /**
     * Mover un curso a la papelera (status = 2).
     */
    public function destroy(string $id)
    {
        try {
            $curso = Cursos::findOrFail($id);
            $curso->update(['status' => 2]);

            CourseActionLog::create([
                'curso_id' => $curso->id,
                'nombre_curso' => $curso->nombre,
                'user_id' => Auth::id(),
                'accion' => 'Eliminado',
                'detalles' => 'Curso enviado a la papelera.',
                'fecha_accion' => now(),
            ]);

            return redirect()->route('cursos.index')->with('success', 'Curso enviado a la papelera.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al enviar a la papelera: ' . $e->getMessage());
        }
    }

    /**
     * Suspender o Activar un curso (alternar entre status 0 y 1).
     */
    public function toggleStatus($id)
    {
        try {
            $curso = Cursos::findOrFail($id);
            $newStatus = ($curso->status == 1) ? 0 : 1;
            $curso->update(['status' => $newStatus]);
            
            $accion = $newStatus == 1 ? 'Activado' : 'Suspendido';

            CourseActionLog::create([
                'curso_id' => $curso->id,
                'nombre_curso' => $curso->nombre,
                'user_id' => Auth::id(),
                'accion' => $accion,
                'detalles' => "Curso $accion por el usuario.",
                'fecha_accion' => now(),
            ]);

            return redirect()->route('cursos.index')->with('success', "Curso $accion exitosamente.");
        } catch (\Exception $e) {
            return back()->with('error', 'Error al cambiar el estado del curso: ' . $e->getMessage());
        }
    }

    /**
     * Reactivar un curso (status = 1).
     */
    public function activarCurso($id)
    {
        try {
            $curso = Cursos::findOrFail($id);
            $curso->update(['status' => 1]);

            CourseActionLog::create([
                'curso_id' => $curso->id,
                'nombre_curso' => $curso->nombre,
                'user_id' => Auth::id(),
                'accion' => 'Activado',
                'detalles' => 'Curso reactivado por el usuario.',
                'fecha_accion' => now(),
            ]);

            return redirect()->route('cursos.index')->with('success', 'Curso reactivado exitosamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al activar el curso: ' . $e->getMessage());
        }
    }

    /**
     * Eliminar definitivamente de la BD.
     */
    public function eliminarDefinitivo(Request $request, $id)
    {
        try {
            // Validar la contraseña del usuario autenticado
            if (!Hash::check($request->password, Auth::user()->password)) {
                return back()->with('error', 'Contraseña incorrecta.');
            }

            if (Auth::user()?->puesto != 'Administrador') {
                return back()->with('error', 'No tienes permisos para realizar esta acción.');
            }

            $curso = Cursos::findOrFail($id);
            $nombre = $curso->nombre;
            $curso->delete();

            return redirect()->route('cursos.index')->with('success', "El curso '$nombre' ha sido eliminado permanentemente.");
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar el curso: ' . $e->getMessage());
        }
    }

    public function show(Cursos $curso)
    {
        return view('cursos.show', compact('curso'));
    }

    public function edit(Cursos $curso)
    {
        $coloresPorPaso = $this->calcularProgresoPaso($curso);
        return view('cursos.edit', compact('curso', 'coloresPorPaso'));
    }

    /**
     * Iniciar la creación de un nuevo curso.
     */
    public function iniciarCurso()
    {
        try {
            $tempId = Str::random(8);
            $curso = Cursos::create([
                'nomenclatura' => 'TEMP-' . $tempId,
                'nombre' => 'Borrador Curso ' . date('Y-m-d H:i'),
                'status' => 1,
            ]);

            session(['curso_id' => $curso->id]);
            session()->forget('nomenclatura_generada');

            return redirect()->route('curso.paso1')->with('success', 'Formulario de creación iniciado.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al iniciar el curso: ' . $e->getMessage());
        }
    }

    /**
     * Iniciar la creación de un subcurso vinculado a un curso padre.
     */
    public function iniciarSubcursos($id)
    {
        try {
            $parent = Cursos::findOrFail($id);
            $tempId = Str::random(8);
            
            // Creamos el subcurso borrador vinculándolo al padre
            $subcurso = Cursos::create([
                'nomenclatura' => 'TEMP-SUB-' . $tempId,
                'nombre' => 'Subcurso de ' . $parent->nombre . ' - ' . date('Y-m-d H:i'),
                'parent_id' => $parent->id,
                'status' => 1,
            ]);

            session(['curso_id' => $subcurso->id]);
            session()->forget('nomenclatura_generada');

            return redirect()->route('curso.paso1')->with('success', 'Formulario de subcurso iniciado.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error al iniciar el subcurso: ' . $e->getMessage());
        }
    }

    // --- MÉTODOS DE PASOS ---

    public function crearPaso1()
    {
        $cursoId = session('curso_id');
        $curso = Cursos::find($cursoId);
        $datosPadre = null;
        return view('cursos.paso1', compact('curso', 'datosPadre'));
    }

    public function guardarPaso1(Request $request)
    {
        $cursoId = session('curso_id');
        $validated = $request->validate([
            'Nomenclatura' => 'required|string|max:255|unique:cursos,nomenclatura,' . $cursoId,
            'NombredelCurso' => 'required|string|max:255',
            'DescripciondeCurso' => 'required|string|max:2000',
            'CostodelCurso' => 'required|numeric',
            'InstructorResponsable' => 'required|string|max:255',
            'FechadeInicio' => 'required|date',
            'FechadeTermino' => 'required|date|after_or_equal:FechadeInicio',
            'Duracioncurso' => 'required|string|max:255',
        ]);

        $curso = Cursos::findOrFail($cursoId);

        $curso->update([
            'nomenclatura' => $validated['Nomenclatura'],
            'nombre' => $validated['NombredelCurso'],
            'descripcion' => $validated['DescripciondeCurso'],
            'costo' => $validated['CostodelCurso'],
            'instructor_responsable' => $validated['InstructorResponsable'],
            'fecha_inicio' => $validated['FechadeInicio'],
            'fecha_termino' => $validated['FechadeTermino'],
            'duracion' => $validated['Duracioncurso'],
        ]);

        session(['cursos_paso1' => $validated]);
        return redirect()->route('curso.paso2');
    }

    public function mostrarPaso2() { return view('cursos.paso2', ['curso' => Cursos::find(session('curso_id'))]); }
    public function guardarPaso2(Request $request) { 
        $v = $request->validate(['Virtual' => 'nullable|string', 'Presencial' => 'nullable|string', 'Mixto' => 'nullable|string']);
        $curso = Cursos::findOrFail(session('curso_id'));
        $curso->update(['virtual' => $v['Virtual'] ?? 'No', 'presencial' => $v['Presencial'] ?? 'No', 'mixto' => $v['Mixto'] ?? 'No']);
        session(['cursos_paso2' => $v]);
        return redirect()->route('curso.paso3');
    }

    public function mostrarPaso3() { return view('cursos.paso3', ['curso' => Cursos::find(session('curso_id'))]); }
    public function guardarPaso3(Request $request) {
        $v = $request->validate(['SinFecha' => 'nullable|string', 'DriveSinFecha' => 'nullable|string', 'Facebook' => 'nullable|string', 'DriveFacebook' => 'nullable|string', 'Linkedin' => 'nullable|string', 'DriveLinkedin' => 'nullable|string', 'Instagram' => 'nullable|string', 'DriveInstagram' => 'nullable|string']);
        $curso = Cursos::findOrFail(session('curso_id'));
        $curso->update([
            'sin_fecha' => $v['SinFecha'] ?? '',
            'drive_sin_fecha' => $v['DriveSinFecha'] ?? '',
            'facebook' => $v['Facebook'] ?? '',
            'drive_facebook' => $v['DriveFacebook'] ?? '',
            'linkedin' => $v['Linkedin'] ?? '',
            'drive_linkedin' => $v['DriveLinkedin'] ?? '',
            'instagram' => $v['Instagram'] ?? '',
            'drive_instagram' => $v['DriveInstagram'] ?? '',
        ]);
        session(['cursos_paso3' => $v]);
        return redirect()->route('curso.paso4');
    }

    public function mostrarPaso4() { return view('cursos.paso4', ['curso' => Cursos::find(session('curso_id')), 'archivosLocales' => []]); }
    public function guardarPaso4(Request $request) {
        $v = $request->validate(['Temario' => 'nullable|string', 'DriveTemario' => 'nullable|string', 'Itinerario' => 'nullable|string', 'DriveItinerario' => 'nullable|string', 'Planeación' => 'nullable|string', 'DrivePlaneación' => 'nullable|string']);
        $curso = Cursos::findOrFail(session('curso_id'));
        $curso->update([
            'temario' => $v['Temario'] ?? '',
            'drive_temario' => $v['DriveTemario'] ?? '',
            'itinerario' => $v['Itinerario'] ?? '',
            'drive_itinerario' => $v['DriveItinerario'] ?? '',
            'planeacion' => $v['Planeación'] ?? '',
            'drive_planeacion' => $v['DrivePlaneación'] ?? '',
        ]);
        session(['cursos_paso4' => $v]);
        return redirect()->route('curso.paso5');
    }

    public function mostrarPaso5() { return view('cursos.paso5', ['curso' => Cursos::find(session('curso_id')), 'archivosLocales' => []]); }
    public function guardarPaso5(Request $request) {
        $v = $request->validate(['Digital' => 'nullable|string', 'DriveDigital' => 'nullable|string', 'Impreso_Presentable' => 'nullable|string']);
        $curso = Cursos::findOrFail(session('curso_id'));
        $curso->update(['digital' => $v['Digital'] ?? '', 'drive_digital' => $v['DriveDigital'] ?? '', 'impreso_presentable' => $v['Impreso_Presentable'] ?? '']);
        session(['cursos_paso5' => $v]);
        return redirect()->route('curso.paso6');
    }

    public function mostrarPaso6() { return view('cursos.paso6', ['curso' => Cursos::find(session('curso_id')), 'archivosLocales' => []]); }
    public function guardarPaso6(Request $request) {
        $v = $request->validate(['Presentación' => 'nullable|string', 'Evaluación_diagnostica' => 'nullable|string', 'EvaluaciondeSatisfacción' => 'nullable|string', 'EvaluacionFinal' => 'nullable|string', 'DC3' => 'nullable|string']);
        $curso = Cursos::findOrFail(session('curso_id'));
        $curso->update([
            'presentacion' => $v['Presentación'] ?? '',
            'evaluacion_diagnostica' => $v['Evaluación_diagnostica'] ?? '',
            'evaluacion_satisfaccion' => $v['EvaluaciondeSatisfacción'] ?? '',
            'evaluacion_final' => $v['EvaluacionFinal'] ?? '',
            'dc3' => $v['DC3'] ?? '',
        ]);
        session(['cursos_paso6' => $v]);
        return redirect()->route('curso.paso7');
    }

    public function mostrarPaso7() { return view('cursos.paso7', ['curso' => Cursos::find(session('curso_id')), 'archivosLocales' => []]); }
    public function guardarPaso7(Request $request) {
        $v = $request->validate([
            'FechadeRegistro_STPS' => 'nullable|date',
            'Formato_DC5' => 'nullable|string',
            'Formato_DC5_Tienefirma' => 'nullable|string',
            'Certificadodecomprobacion' => 'nullable|string',
            'DrivedeCertificadodecomprobacion' => 'nullable|string',
            'Cartapoder_tienefirma' => 'nullable|string',
            'DriveCartapoder' => 'nullable|string',
            'UDEMY' => 'nullable|string',
        ]);
        $curso = Cursos::findOrFail(session('curso_id'));
        $curso->update([
            'fecha_registro_stps' => $v['FechadeRegistro_STPS'],
            'formato_dc5' => $v['Formato_DC5'] ?? '',
            'formato_dc5_tiene_firma' => $v['Formato_DC5_Tienefirma'] ?? '',
            'certificado_comprobacion' => $v['Certificadodecomprobacion'] ?? '',
            'drive_certificado_comprobacion' => $v['DrivedeCertificadodecomprobacion'] ?? '',
            'carta_poder_tiene_firma' => $v['Cartapoder_tienefirma'] ?? '',
            'drive_carta_poder' => $v['DriveCartapoder'] ?? '',
            'udemy' => $v['UDEMY'] ?? '',
        ]);

        CourseActionLog::create([
            'curso_id' => $curso->id,
            'nombre_curso' => $curso->nombre,
            'user_id' => Auth::id(),
            'accion' => 'Finalizado',
            'detalles' => 'Proceso de creación de curso completado.',
            'fecha_accion' => now(),
        ]);

        session()->forget(['curso_id', 'cursos_paso1', 'cursos_paso2', 'cursos_paso3', 'cursos_paso4', 'cursos_paso5', 'cursos_paso6']);
        return redirect()->route('cursos.index')->with('success', 'Curso creado con éxito.');
    }

    // --- EDICIÓN POR PASOS ---

    public function editPaso(Cursos $curso, $paso)
    {
        $rutaLocal = null;
        switch($paso) {
            case 1: return view('cursos.edit-paso1', compact('curso'));
            case 2: return view('cursos.edit-paso2', compact('curso'));
            case 3: return view('cursos.edit-paso3', compact('curso', 'rutaLocal'));
            case 4: return view('cursos.edit-paso4', compact('curso', 'rutaLocal'));
            case 5: return view('cursos.edit-paso5', compact('curso', 'rutaLocal'));
            case 6: return view('cursos.edit-paso6', compact('curso', 'rutaLocal'));
            case 7: return view('cursos.edit-paso7', compact('curso', 'rutaLocal'));
            default: return redirect()->route('cursos.index');
        }
    }

    public function updatePaso(Request $request, Cursos $curso, $paso)
    {
        if ($paso == 1) {
            $request->validate([
                'Nomenclatura' => 'required|string|max:255|unique:cursos,nomenclatura,' . $curso->id,
            ]);
        }

        $map = [
            'Nomenclatura' => 'nomenclatura', 'NombredelCurso' => 'nombre', 'DescripciondeCurso' => 'descripcion', 'CostodelCurso' => 'costo',
            'InstructorResponsable' => 'instructor_responsable', 'FechadeInicio' => 'fecha_inicio', 'FechadeTermino' => 'fecha_termino',
            'Duracioncurso' => 'duracion', 'Virtual' => 'virtual', 'Presencial' => 'presencial', 'Mixto' => 'mixto',
            'SinFecha' => 'sin_fecha', 'DriveSinFecha' => 'drive_sin_fecha', 'Facebook' => 'facebook', 'DriveFacebook' => 'drive_facebook',
            'Linkedin' => 'linkedin', 'DriveLinkedin' => 'drive_linkedin', 'Instagram' => 'instagram', 'DriveInstagram' => 'drive_instagram',
            'Temario' => 'temario', 'DriveTemario' => 'drive_temario', 'Itinerario' => 'itinerario', 'DriveItinerario' => 'drive_itinerario',
            'Planeación' => 'planeacion', 'DrivePlaneación' => 'drive_planeacion', 'Digital' => 'digital', 'DriveDigital' => 'drive_digital',
            'Impreso_Presentable' => 'impreso_presentable', 'Presentación' => 'presentacion', 'Evaluación_diagnostica' => 'evaluacion_diagnostica',
            'EvaluaciondeSatisfacción' => 'evaluacion_satisfaccion', 'EvaluacionFinal' => 'evaluacion_final', 'DC3' => 'dc3',
            'FechadeRegistro_STPS' => 'fecha_registro_stps', 'Formato_DC5' => 'formato_dc5', 'Formato_DC5_Tienefirma' => 'formato_dc5_tiene_firma',
            'Certificadodecomprobacion' => 'certificado_comprobacion', 'DrivedeCertificadodecomprobacion' => 'drive_certificado_comprobacion',
            'Cartapoder_tienefirma' => 'carta_poder_tiene_firma', 'DriveCartapoder' => 'drive_carta_poder', 'UDEMY' => 'udemy'
        ];

        $data = [];
        foreach ($request->all() as $key => $value) {
            if (isset($map[$key])) $data[$map[$key]] = $value;
        }

        $curso->update($data);

        return redirect()->route('cursos.edit', $curso->id)->with('success', "Paso $paso actualizado.");
    }

    private function calcularProgresoPaso(Cursos $curso): array
    {
        $progreso = [];
        $pasosCampos = [
            1 => ['nombre', 'nomenclatura', 'costo'],
            2 => ['virtual', 'presencial', 'mixto'],
            3 => ['sin_fecha', 'facebook'],
            4 => ['temario', 'itinerario'],
            5 => ['digital'],
            6 => ['presentacion', 'dc3'],
            7 => ['formato_dc5', 'udemy'],
        ];

        foreach ($pasosCampos as $paso => $campos) {
            $llenos = 0;
            foreach ($campos as $campo) {
                if (!empty($curso->getRawOriginal($campo))) $llenos++;
            }
            $porcentaje = (count($campos) > 0) ? ($llenos / count($campos)) * 100 : 0;
            $progreso[$paso] = ($porcentaje >= 80) ? 'btn-success' : (($porcentaje >= 50) ? 'btn-warning' : 'btn-danger');
        }
        return $progreso;
    }

    public function finalizacionForzada(Request $request)
    {
        $curso = Cursos::find(session('curso_id'));
        if ($curso) {
            CourseActionLog::create(['curso_id' => $curso->id, 'nombre_curso' => $curso->nombre, 'user_id' => Auth::id(), 'accion' => 'Forzado', 'detalles' => 'Finalización forzada.', 'fecha_accion' => now()]);
            session()->forget(['curso_id', 'cursos_paso1', 'cursos_paso2', 'cursos_paso3', 'cursos_paso4', 'cursos_paso5', 'cursos_paso6']);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }

    public function getFechaInicio($id) { return response()->json(['fecha_inicio' => Cursos::findOrFail($id)->fecha_inicio]); }
    public function exportarExcel() { return Excel::download(new CursosExport(Cursos::where('status', 1)->get()), 'cursos.xlsx'); }
    public function exportarCsv() { return Excel::download(new CursosExport(Cursos::where('status', 1)->get()), 'cursos.csv'); }
    public function rutas() { return view('cursos.ruta'); }
    public function prepararRutaSubcurso() { return back()->with('error', 'Función no disponible en el hosting actual.'); }
}
