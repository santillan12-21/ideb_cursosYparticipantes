@extends('home')
@section('title', '- Editar Curso')
@section('nav')

<style>
    .container{
        margin-top: 150px!important;
        max-width: 1200px !important;
    }
    h2 {
        text-align: center;
        margin-bottom: 30px;
    }
    .btn {
        font-size: 1.1 rem;
        padding: 15px;
        text-align: center;
    }
    .btn-block {
        width: 100%;
    }
    .mb-4 {
        margin-bottom: 1.5rem;
    }
    .mt-5 {
        margin-top: 3rem;
    }
    .text-center {
        text-align: center;
    }
    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }   
    .btn-danger {
        background-color: #dc3545;
        color: white;
        padding: 10px 20px;
        font-size: 1.2rem;
        border-radius: 5px;
        text-decoration: none;  
    }

</style>
<div class="container">
    <!-- Título con espacio inferior -->
    <h2 class="mb-4">Editar Curso: {{ $curso->NombredelCurso }}</h2>

    <!-- Botones de pasos con espacio -->
<div class="row">
    @for ($paso = 1; $paso <= 7; $paso++)
        <div class="col-md-4 mb-4">
            <a href="{{ route('cursos.edit.paso', [$curso->id, $paso]) }}" 
               class="btn {{ $coloresPorPaso[$paso] ?? 'btn-secondary' }} btn-block">
                Paso {{ $paso }}:
                @switch($paso)
                    @case(1) Datos del Curso @break
                    @case(2) Modalidad del Curso @break
                    @case(3) Formato de Flyer / Imagen @break
                    @case(4) Documentos del Curso @break
                    @case(5) Material de Apoyo @break
                    @case(6) Documentos de Evaluación @break
                    @case(7) Documentación STPS y Certificados @break
                @endswitch
            </a>
        </div>
    @endfor
</div>


    <!-- Botón "Salir" centrado con espacio superior -->
    <div class="row mt-5">
        <div class="col-md-12 text-center">
            <a href="{{ route('cursos.index') }}" class="btn btn-danger">Salir</a>
        </div>
    </div>
</div>
@endsection
