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
        dd($request->all());
        // Validación inicial + validación condicional
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
            'FechadelCurso' => 'required|date',
            'cursos' => 'required|array|min:1', // IDs de los cursos seleccionados
        ];

        // Validación condicional para el campo Pago
        if (in_array($request->EstadoDePago, ['Pagado', 'Anticipo'])) {
            $rules['Pago'] = ['required', 'regex:/^\d+(\.\d{1,2})?$/']; // Solo números o decimales (ejemplo: 100, 100.50)
        } else {
            $rules['Pago'] = 'nullable'; // Pago es opcional
        }

        // Validar todos los campos
        $validated = $request->validate($rules);

        // Crear el participante
        $participante = new Participantes();
        $participante->fill($validated);
        $participante->Pago = $request->Pago ?? null; // Guardar null si no se proporciona un valor
        $participante->save();

        // Guardar las inscripciones en la tabla intermedia
        foreach ($request->cursos as $curso_id) {
            $inscripcion = new Inscripcion();
            $inscripcion->participante_id = $participante->id;
            $inscripcion->curso_id = $curso_id;
            $inscripcion->save();
        }

        // Redireccionar con mensaje de éxito
        return redirect()->route('registro.index')->with('success', 'Participante registrado exitosamente.');
    }
}
