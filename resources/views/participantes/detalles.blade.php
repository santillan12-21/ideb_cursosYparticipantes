<!-- resources/views/participantes/detalles.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="text-center mt-5">Detalles del Participante</h3>
    
    <div class="text-center mt-3 mb-4">
        @if(auth()->user()?->puesto != 'Operacion')
        <a href="{{ route('participantes.descargar-pdf', ['id' => $participante->id]) }}" class="btn btn-primary">
            <i class="fas fa-download"></i> Descargar PDF
        </a>
        @endif
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Regresar</a>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h5 class="card-title">{{ $participante->NombredelPostulante }}</h5>
            <p><strong>Id:</strong> {{ $participante->N }}</p>
            <p><strong>Correo:</strong> {{ $participante->Correo }}</p>
            <p><strong>Teléfono:</strong> {{ $participante->Telefono }}</p>
            <p><strong>Edad:</strong> {{ $participante->Edad }}</p>
            <p><strong>Dirección:</strong> {{ $participante->Direccion }}</p>
            <p><strong>Escolaridad:</strong> {{ $participante->Escolaridad }}</p>
            <p><strong>CURP:</strong> {{ $participante->Curp }}</p>
            <p><strong>Razón Social:</strong> {{ $participante->RazónSocial }}</p>
            <p><strong>Empresa:</strong> {{ $participante->Empresa }}</p>
            <p><strong>RFC Empresa:</strong> {{ $participante->RFCEmpresa }}</p>
            <p><strong>Ocupación:</strong> {{ $participante->Ocupacion }}</p>
            <p><strong>Puesto:</strong> {{ $participante->Puesto }}</p>
            <p><strong>Pago:</strong> @php
                $pago = !empty($participante->Pago) && is_numeric($participante->Pago) ? floatval($participante->Pago) : 0;
            @endphp
            ${{ number_format($pago, 2) }}</p>
            <p><strong>Estado de Pago:</strong> {{ $participante->EstadoDePago }}</p>
            <p><strong>Fecha del Curso:</strong> {{ $participante->FechadelCurso }}</p>
            <p><strong>Cursos Inscritos:</strong></p>
            @if($participante->cursos->isEmpty())
                <p>No hay cursos inscritos</p>
            @else
                <ul>
                    @foreach($participante->cursos as $curso)
                        <li>{{ $curso->NombredelCurso }} ({{ $curso->pivot->FechadelCurso }})</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

</div>
@endsection
