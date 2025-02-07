<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participantes;
use App\Models\Cursos;
use App\Models\Inscripcion;

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
            'Curp' => 'required|string|max:255',
            'RazónSocial' => 'nullable|string|max:200',
            'Empresa' => 'required|string|max:255',
            'RFCEmpresa' => 'nullable|string|max:100',
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

        $participante = new Participantes();
        $participante->fill($validated);
        $participante->Pago = $request->Pago ?? null;

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
