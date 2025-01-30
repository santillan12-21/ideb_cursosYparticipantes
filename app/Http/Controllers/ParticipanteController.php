<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participantes;
use App\Models\Cursos;

class ParticipanteController extends Controller
{
    public function index()
    {
        $cursos = Cursos::all();
        $participantes = Participantes::with('cursos')->get(); // Aquí usa la relación corregida

        return view('participantes.index', compact('cursos', 'participantes'));
    }

    public function create()
    {
        return view('participantes.create');
    }

    public function edit($N) {
        $participante = Participantes::where('N', $N)->firstOrFail();
        return view('participantes.edit', compact('participante'));
    }

    public function update(Request $request, $N) {
        $request->validate([
            'NombredelPostulante' => 'required',
            'Correo' => 'required|email',
            'Telefono' => 'required',
            'Edad' => 'required|numeric',
            'Direccion' => 'required',
            'Escolaridad' => 'required',
            'Curp' => 'required',
            'RazonSocial' => 'required',
            'Empresa' => 'required',
            'RFCEmpresa' => 'required',
            'Puesto' => 'required',
            'Pago' => 'required',
            'FechadelCurso' => 'required|date',
            'EstadoDePago' => 'required',
            'CursoInscrito' => 'required',
        ]);

        $participante = Participantes::where('N', $N)->firstOrFail();
        $participante->update($request->all());

        // Sincronizar cursos inscritos
        $participante->cursos()->sync(
            collect($request->CursoInscrito)->mapWithKeys(function ($cursoId) use ($request) {
                return [$cursoId => ['FechadelCurso' => $request->FechadelCurso]];
            })
        );

        return redirect()->route('participantes.index')->with('success', 'Participante actualizado correctamente.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'N' => 'required|string|max:255',
            'NombredelPostulante' => 'required|string|max:255',
            'Correo' => 'required|email',
            'Telefono' => 'required|string|max:255',
            'Edad' => 'required|string|max:255', // Cambia a integer si deseas que sea numérico
            'Direccion' => 'required|string|max:255',
            'Escolaridad' => 'required|string|max:255',
            'Curp' => 'required|string|max:255',
            'RazonSocial' => 'required|string|max:200',
            'Empresa' => 'required|string|max:255',
            'RFCEmpresa' => 'required|string|max:100',
            'Puesto' => 'required|string|max:255',
            'Pago' => 'required|string|max:255',
            'EstadoDePago' => 'nullable|string|max:255', // Puede ser nulo si no se selecciona
            'FechadelCurso' => 'required|string|max:255', // Cambia a date si deseas validar como fecha
        ]);

        $participante = Participantes::create($request->except('CursoInscrito'));
        $participante->cursos()->attach($request->CursoInscrito, ['FechadelCurso' => $request->FechadelCurso]);

        return redirect()->back()->with('success', 'Inscripción realizada con éxito.');
    }

    public function destroy($N) {
        $participante = Participantes::where('N', $N)->firstOrFail();
        $participante->delete();

        return redirect()->route('participantes.index')->with('success', 'Participante eliminado correctamente.');
    }
}
