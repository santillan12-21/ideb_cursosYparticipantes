<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Models\Participantes;
use App\Models\Cursos;
use App\Models\Inscripcion;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ParticipantesExport;
use Illuminate\Support\Facades\Log;
use App\Models\ParticipantActionLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ParticipanteController extends Controller
{
    /**
     * Mostrar la lista de participantes.
     */
    public function index()
    {
    // Obtener todos los cursos
    $cursos = Cursos::all();

    // Obtener participantes ordenados por su número
    $participantes = Participantes::orderBy('N', 'asc')->get();

    return view('participantes.index', compact('cursos', 'participantes'));
    }


    /**
     * Mostrar el formulario para crear un nuevo participante.
     */
    public function create()
    {
        // Obtener todos los cursos disponibles
        $cursos = Cursos::all();
        return view('participantes.create', compact('cursos'));
    }

    /**
     * Mostrar el formulario para editar un participante existente.
     */
    public function edit($id)
    {

        // Buscar el participante por su ID (clave primaria)
        $participante = Participantes::findOrFail($id);
        $cursos = Cursos::all(); // Obtener todos los cursos disponibles
        return view('participantes.edit', compact('participante', 'cursos'));
    }

    /**
     * Actualizar un participante existente.
     */
    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'N' => 'required|string|max:255|unique:participantes,N,' . $id, // Validar que N sea único
            'NombredelPostulante' => 'required|string|max:255',
            'Correo' => 'required|email|max:255',
            'Telefono' => 'required|string|max:255',
            'Edad' => 'required|integer',
            'Direccion' => 'required|string|max:255',
            'Escolaridad' => 'required|string|max:255',
            'Curp' => 'required|string|max:255',
            'RazónSocial' => 'nullable|string|max:255',
            'Empresa' => 'required|string|max:255',
            'RFCEmpresa' => 'nullable|string|max:255',
            'Ocupacion' => 'nullable|string|max:255',
            'Puesto' => 'required|string|max:255',
            'Pago' => 'required|numeric',
            'EstadoDePago' => 'required|string|max:255',
            'FechadelCurso' => 'required|date',
            'cursos' => 'required|array|min:1',
        ]);

            Log::info('Datos validados:', $validated);  // Log para debug

            $participante = Participantes::findOrFail($id);

        // Actualizar los datos del participante
        $participante->update($validated);

        // Registrar la acción en el historial
        ParticipantActionLog::create([
            'participant_id' => $participante->id,
            'nombre_postulante' => $participante->NombredelPostulante,
            'correo' => $participante->Correo,
            'accion' => 'Editado',
            'user_id' => Auth::id(),
            'detalles' => 'Datos del participante actualizados.',
            'fecha_accion' => now(),
        ]);

        // Actualizar los cursos asociados al participante
        $participante->cursos()->sync($validated['cursos']);

        // Redireccionar con mensaje de éxito
        return redirect()->route('participantes.index')->with('success', 'Participante actualizado correctamente.');
    }

    /**
     * Guardar un nuevo participante en la base de datos.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'N' => 'required|string|max:255|unique:participantes,N',
        'NombredelPostulante' => 'required|string|max:255',
        'Correo' => 'required|email|max:255',
        'Telefono' => 'required|string|max:255',
        'Edad' => 'required|integer',
        'Direccion' => 'required|string|max:255',
        'Escolaridad' => 'required|string|max:255',
        'Curp' => 'required|string|max:255',
        'RazónSocial' => 'nullable|string|max:200',
        'Empresa' => 'required|string|max:255',
        'RFCEmpresa' => 'nullable|string|max:100',
        'Ocupacion' => 'nullable|string|max:255',
        'Puesto' => 'required|string|max:255',
        'Pago' => 'nullable|numeric',
        'EstadoDePago' => 'required|string|max:255',
        'FechadelCurso' => 'required|date',
        'cursos' => 'required|array|min:1',
    ]);

    // Guardar primero el participante
    $participante = new Participantes();
    $participante->fill($validated);
    $participante->save(); // Aquí se genera el ID

    // Ahora sí puedes registrar el log correctamente
    ParticipantActionLog::create([
        'participant_id' => $participante->id,
        'nombre_postulante' => $participante->NombredelPostulante,
        'correo' => $participante->Correo,
        'accion' => 'Creado',
        'user_id' => Auth::id(),
        'detalles' => 'Nuevo participante registrado.',
        'fecha_accion' => now(),
    ]);

    // Guardar las inscripciones
    foreach ($validated['cursos'] as $curso_id) {
        Inscripcion::create([
            'participante_id' => $participante->id,
            'curso_id' => $curso_id,
        ]);
    }

    return redirect()->route('participantes.index')->with('success', 'Participante registrado exitosamente.');
}

    /**
     * Eliminar un participante.
     */
    public function destroy($id)
    {
        $participante = Participantes::findOrFail($id);

        // Cambiar el estado a inactivo
        $participante->update(['estatus' => '0']);

        // Registrar la acción en el historial
        ParticipantActionLog::create([
            'participant_id' => $participante->id,
            'nombre_postulante' => $participante->NombredelPostulante,
            'correo' => $participante->Correo,
            'accion' => 'Eliminado',
            'user_id' => Auth::id(),
            'detalles' => 'Participante desactivado.',
            'fecha_accion' => now(),
        ]);

        return redirect()->route('participantes.index')->with('success', 'Participante desactivado exitosamente.');
    }

    /**
     * Filtrar participantes según los criterios proporcionados.
     */
    public function filtrar(Request $request)
    {
        // Consulta base para participantes
        $query = Participantes::query();

        // Filtrar por Curso
        if ($request->has('curso') && $request->curso) {
            $query->whereHas('cursos', function ($q) use ($request) {
                $q->where('cursos.id', $request->curso);
            });
        }

        // Filtrar por Estado de Pago
        if ($request->has('estado_pago') && $request->estado_pago) {
            $query->where('EstadoDePago', $request->estado_pago);
        }

        // Filtrar por Rango de Costo (Mínimo)
        if ($request->has('min_costo') && $request->min_costo) {
            $minCosto = floatval(str_replace([',', '$'], '', $request->min_costo));
            $query->whereRaw("CAST(REPLACE(REPLACE(Pago, ',', ''), '$', '') AS DECIMAL(10, 2)) >= ?", [$minCosto]);
        }

        // Filtrar por Rango de Costo (Máximo)
        if ($request->has('max_costo') && $request->max_costo) {
            $maxCosto = floatval(str_replace([',', '$'], '', $request->max_costo));
            $query->whereRaw("CAST(REPLACE(REPLACE(Pago, ',', ''), '$', '') AS DECIMAL(10, 2)) <= ?", [$maxCosto]);
        }

        // Barra de Búsqueda General
        if ($request->has('busqueda') && $request->busqueda) {
            $busqueda = $request->busqueda;
            $query->where(function ($q) use ($busqueda) {
                $q->where('N', 'LIKE', '%' . $busqueda . '%') // Buscar por N
                  ->orWhere('NombredelPostulante', 'LIKE', '%' . $busqueda . '%')
                  ->orWhere('Correo', 'LIKE', '%' . $busqueda . '%')
                  ->orWhere('Telefono', 'LIKE', '%' . $busqueda . '%')
                  ->orWhere('Curp', 'LIKE', '%' . $busqueda . '%')
                  ->orWhere('Empresa', 'LIKE', '%' . $busqueda . '%');
            });
        }

        // Obtener resultados
        $participantes = $query->with('cursos')->get();

        // Obtener todos los cursos disponibles para el filtro
        $cursos = Cursos::all();

        // Pasar datos a la vista
        return view('participantes.index', compact('participantes', 'cursos'));
    }

    public function showDetails($id)
    {
        // Obtener el participante por su ID
        $participante = Participantes::with('cursos')->findOrFail($id);

        // Pasar los datos a la vista
        return view('participantes.detalles', compact('participante'));
    }

    public function downloadPdf($id)
    {
        // Obtener el participante por su ID
        $participante = Participantes::with('cursos')->findOrFail($id);

        // Cargar la vista PDF y pasar los datos
        $pdf = Pdf::loadView('participantes.pdf', compact('participante'));

        // Descargar el PDF
        return $pdf->download('detalles-participante-' . $participante->NombredelPostulante . '.pdf');
    }

    public function exportarExcel()
    {
        $participantes = Participantes::with('cursos')->get();
        return Excel::download(new ParticipantesExport($participantes), 'participantes.xlsx');
    }

    public function exportarCsv()
    {
        $participantes = Participantes::with('cursos')->get();
        return Excel::download(new ParticipantesExport($participantes), 'participantes.csv');
    }

        public function activar($id)
        {
            try {
                $participante = Participantes::findOrFail($id);

                // Cambiar el estado a activo (estatus = 1)
                $participante->update(['estatus' => 1]);

                // Registrar la acción en el historial
                ParticipantActionLog::create([
                    'participant_id' => $participante->id,
                    'nombre_postulante' => $participante->NombredelPostulante,
                    'correo' => $participante->Correo,
                    'accion' => 'Activado',
                    'user_id' => Auth::id(),
                    'detalles' => 'Participante activado nuevamente.',
                    'fecha_accion' => now(),
                ]);

                return redirect()->route('configuraciones.index')->with('success', 'Participante activado exitosamente.');
            } catch (\Exception $e) {
                return back()->with('error', 'Error al activar el participante: ' . $e->getMessage());
            }
        }
        public function eliminarDefinitivo(Request $request, $id)
            {
                try {
                    // Validar la contraseña del usuario autenticado
                    if (!Hash::check($request->password, Auth::user()->password)) {
                        return back()->with('error', 'Contraseña incorrecta.');
                    }

                    // Buscar el participante por ID
                    $participante = Participantes::findOrFail($id);

                    // Eliminar el participante de la base de datos
                    $participante->delete();

                    // Registrar la acción en el historial
                    ParticipantActionLog::create([
                        'participant_id' => $participante->id,
                        'nombre_postulante' => $participante->NombredelPostulante,
                        'correo' => $participante->correo,
                        'accion' => 'Eliminado Definitivamente',
                        'user_id' => Auth::id(),
                        'detalles' => 'Participante eliminado definitivamente.',
                        'fecha_accion' => now(),
                    ]);

                    return redirect()->route('configuraciones.index')->with('success', 'Participante eliminado definitivamente.');
                } catch (\Exception $e) {
                    return back()->with('error', 'Error al eliminar el participante: ' . $e->getMessage());
                }
            }

}
