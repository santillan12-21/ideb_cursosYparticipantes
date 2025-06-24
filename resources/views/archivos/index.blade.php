@php
    use Illuminate\Support\Facades\Storage;
@endphp
@extends('home')
@section('title', '- Archivos en Carpeta: ' . $carpeta)
@section('nav')

<style>
   
    .container {
        margin: 20px auto;
        max-width: 900px;
    }
    input{
        width: 100%;
        max-width: 100%;
    }
    </style>
<div class="container" style="margin-top: 100px; align-content: center">
    <h1 style="text-align:center">Archivos en la Carpeta: {{ $carpeta }}</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulario para subir archivos -->
    <form action="{{ route('archivos.upload') }}" method="POST" enctype="multipart/form-data" class="mb-4">
        @csrf
        <div class="form-group">
            <input type="file" name="archivo" class="form-control-file" required style="width: 100%; max-width: 100%;">
        </div>
        <button type="submit" class="btn btn-primary">Subir Archivo</button>
    </form>

    <!-- Formulario para crear carpetas -->
    <form action="{{ route('archivos.create-folder') }}" method="POST" class="mb-4">
        @csrf
        <div class="form-group">
            <input type="text" name="nombre_carpeta" class="form-control" placeholder="Nombre de la carpeta" required style="width: 100%; max-width: 100%;">
        </div>
        <button type="submit" class="btn btn-info">Crear Carpeta</button>
    </form>

    <!-- Lista de carpetas -->
    <h2>Carpetas</h2>
    @if (count($carpetas) > 0)
        <div class="list-group mb-4">
            @foreach ($carpetas as $carpeta)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('archivos.open-folder', ['carpeta' => basename($carpeta)]) }}">
                        {{ basename($carpeta) }}
                    </a>
                    <form action="{{ route('archivos.delete-folder', ['carpeta' => basename($carpeta)]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar Carpeta</button>
                    </form>
                </div>
            @endforeach
        </div>
    @else
        <p>No hay carpetas en esta ubicación.</p>
    @endif

    <!-- Lista de archivos -->
    <h2>Archivos</h2>
    @if (count($archivos) > 0)
        <div class="list-group mb-4">
            @foreach ($archivos as $archivo)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    @if (in_array(pathinfo($archivo, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                        <img src="{{ Storage::url($archivo) }}" alt="{{ basename($archivo) }}" style="max-width: 100px; max-height: 100px;">
                    @else
                        <span>{{ basename($archivo) }}</span>
                    @endif
                    <div>
                        <a href="{{ route('archivos.download', ['archivo' => basename($archivo)]) }}" class="btn btn-success btn-sm">Descargar</a>
                        <form action="{{ route('archivos.delete', ['archivo' => basename($archivo)]) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p>No hay archivos en esta carpeta.</p>
    @endif
</div>
@endsection
