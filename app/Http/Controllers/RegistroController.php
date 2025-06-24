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
        'Ocupacion' => 'required|string|max:255',
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
        $lastNumber = intval(substr($lastParticipante->N, 5));
        $newNumber = $lastNumber + 1;
    } else {
        $newNumber = 1;
    }

    $formattedNumber = str_pad($newNumber, 4, '0', STR_PAD_LEFT);
    $nValue = "IC-{$year}{$formattedNumber}";

    $participante = new Participantes();
    $participante->fill($validated);
    $participante->Pago = $request->Pago ?? null;
    $participante->N = $nValue;

    $inscripciones = [];
    foreach ($request->cursos as $curso_id) {
        $curso = Cursos::findOrFail($curso_id);
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

    // // Mostrar los datos guardados para depuración
    // dd([
    //     'validated' => $validated,
    //     'participante' => $participante,
    //     'inscripciones' => $inscripciones
    // ]);

    // Este código no se ejecutará por el dd() anterior
    return redirect('/Inicio')->with('success', 'Participante registrado exitosamente.');
}
}
