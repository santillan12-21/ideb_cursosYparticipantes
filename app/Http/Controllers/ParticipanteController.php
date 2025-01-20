<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\participantes;

class ParticipanteController extends Controller
{
    public function index() {
        $participantes = ParticipanteS::all();
        return view('participantes.index', compact('participantes'));
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
            'Empresa' => 'required',
            'Puesto' => 'required',
            'Pago' => 'required',
            'FechadelCurso' => 'required|date',
        ]);

        $participante = Participantes::where('N', $N)->firstOrFail();
        $participante->update($request->all());

        return redirect()->route('participantes.index')->with('success', 'Participante actualizado correctamente.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'N' => 'required|unique:participantes',
            'NombredelPostulante' => 'required',
            'Correo' => 'required|email',
            'Telefono' => 'required',
            'Edad' => 'required|numeric',
            'Direccion' => 'required',
            'Escolaridad' => 'required',
            'Curp' => 'required',
            'Empresa' => 'required',
            'Puesto' => 'required',
            'Pago' => 'required',
            'FechadelCurso' => 'required|date',
        ]);

        participantes::create($request->all());

        return redirect()->route('participantes.index')->with('success', 'Participante agregado correctamente.');
    }

    public function destroy($N) {
        $participante = Participantes::where('N', $N)->firstOrFail();
        $participante->delete();

        return redirect()->route('participantes.index')->with('success', 'Participante eliminado correctamente.');
    }
}
