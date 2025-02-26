<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participantes;
use App\Models\Cursos;
use App\Models\Inscripcion;
use Illuminate\Support\Facades\DB;

class RegistroController extends Controller
{
    public function index()
    {
        $cursos = Cursos::all();
        return view('registro.index', compact('cursos'));
    }

    public function store(Request $request)
    {
        $rules = [
            'NombredelPostulante' => 'required|string|max:255',
            'Correo' => 'required|email|max:255',
            'Telefono' => 'required|string|max:255',
            'Edad' => 'required|integer',
            'Direccion' => 'required|string|max:255',
            'Escolaridad' => 'required|string|max:255',
            'Curp' => 'required|string|max:18',
            'RazónSocial' => 'required|string|max:200',
            'Empresa' => 'required|string|max:255',
            'RFCEmpresa' => 'required|string|max:100',
            'Puesto' => 'required|string|max:255',
            'EstadoDePago' => 'required|string|max:255',
            'cursos' => 'required|array|min:1',
        ];

        if (in_array($request->EstadoDePago, ['Pagado', 'Anticipo'])) {
            $rules['Pago'] = ['required', 'regex:/^\d+(\.\d{1,2})?$/'];
        } else {
            $rules['Pago'] = 'nullable';
        }

        $validated = $request->validate($rules);

        // Generar el código autoincremental (N)
        $year = date('y'); // Obtiene los dos últimos dígitos del año actual
        $lastParticipante = DB::table('participantes')
            ->where('N', 'like', "IC-{$year}%")
            ->orderBy('id', 'desc')
            ->first();

        if ($lastParticipante) {
            // Obtener el último número y aumentarlo en 1
            $lastNumber = intval(substr($lastParticipante->N, 5));
            $newNumber = $lastNumber + 1;
        } else {
            // Si no hay registros previos, comenzar desde 1
            $newNumber = 1;
        }

        // Formatear el número con ceros a la izquierda (4 dígitos)
        $formattedNumber = str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        $nValue = "IC-{$year}{$formattedNumber}";

        $participante = new Participantes();
        $participante->fill($validated);
        $participante->Pago = $request->Pago ?? null;
        $participante->N = $nValue; // Asignar el valor generado

        $inscripciones = [];
        foreach ($request->cursos as $curso_id) {
            $curso = Cursos::findOrFail($curso_id);

            // Use FechadeInicio instead of FechadelCurso
            $participante->FechadelCurso = $curso->FechadeInicio;

            $inscripciones[] = [
                'curso_id' => $curso_id
            ];
        }

        $participante->save();

        foreach ($inscripciones as $inscripcionData) {
            $inscripcion = new Inscripcion();
            $inscripcion->participante_id = $participante->id;
            $inscripcion->curso_id = $inscripcionData['curso_id'];
            $inscripcion->save();
        }

        return redirect('/Inicio')->with('success', 'Participante registrado exitosamente.');
    }
}
