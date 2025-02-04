<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participantes;
use App\Models\Cursos;
use App\Models\Inscripcion;

class RegistroController extends Controller
{
    /**
     * Muestra el formulario de registro.
     */
    public function index()
    {
        // Obtener todos los cursos disponibles
        $cursos = Cursos::all();

        // Pasar los cursos a la vista
        return view('registro.index', compact('cursos'));
    }

    /**
     * Guarda un nuevo participante en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'NombredelPostulante' => 'required|string|max:255',
            'Correo' => 'required|email|max:255',
            'Telefono' => 'required|string|max:255',
            'Edad' => 'required|integer',
            'Direccion' => 'required|string|max:255',
            'Escolaridad' => 'required|string|max:255',
            'Curp' => 'required|string|max:255',
            'RazónSocial' => 'required|string|max:255',
            'Empresa' => 'required|string|max:255',
            'RFCEmpresa' => 'required|string|max:255',
            'Puesto' => 'required|string|max:255',
            'Pago' => 'required|string|max:255',
            'EstadoDePago' => 'required|string|max:255',
            'FechadelCurso' => 'required|date',
            'cursos' => 'required|array',
        ]);

        // Crear el participante
        $participante = new Participantes();
        $participante->NombredelPostulante = $validated['NombredelPostulante'];
        $participante->Correo = $validated['Correo'];
        $participante->Telefono = $validated['Telefono'];
        $participante->Edad = $validated['Edad'];
        $participante->Direccion = $validated['Direccion'];
        $participante->Escolaridad = $validated['Escolaridad'];
        $participante->Curp = $validated['Curp'];
        $participante->RazónSocial = $validated['RazónSocial'];
        $participante->Empresa = $validated['Empresa'];
        $participante->RFCEmpresa = $validated['RFCEmpresa'];
        $participante->Puesto = $validated['Puesto'];
        $participante->Pago = $validated['Pago'];
        $participante->EstadoDePago = $validated['EstadoDePago'];
        $participante->FechadelCurso = $validated['FechadelCurso'];

        $participante->save();

        // Guardar las inscripciones en la tabla intermedia
        foreach ($validated['cursos'] as $curso_id) {
            $inscripcion = new Inscripcion();
            $inscripcion->participante_id = $participante->id;
            $inscripcion->curso_id = $curso_id;
            $inscripcion->save();
        }

        // Redireccionar a la lista de participantes
        return redirect()->route('participantes.index')->with('success', 'Participante registrado exitosamente.');
    }
}
