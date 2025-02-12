@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Archivos en la Carpeta: {{ $carpeta }}</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Formulario para subir archivos -->
    <form action="{{ route('archivos.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="archivo" required>
        <button type="submit" class="btn btn-primary">Subir Archivo</button>
    </form>

    <!-- Formulario para crear carpetas -->
    <form action="{{ route('archivos.create-folder') }}" method="POST">
        @csrf
        <input type="text" name="nombre_carpeta" placeholder="Nombre de la carpeta" required>
        <button type="submit" class="btn btn-info">Crear Carpeta</button>
    </form>

    <!-- Lista de carpetas -->
    <ul>
        @foreach ($carpetas as $carpeta)
            <li>
                <a href="{{ route('archivos.open-folder', ['carpeta' => basename($carpeta)]) }}">
                    {{ basename($carpeta) }}
                </a>
                <form action="{{ route('archivos.delete-folder', ['carpeta' => basename($carpeta)]) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Eliminar Carpeta</button>
                </form>
            </li>
        @endforeach
    </ul>

    <!-- Lista de archivos -->
    <ul>
        @foreach ($archivos as $archivo)
            <li>
                {{ basename($archivo) }}
                <a href="{{ route('archivos.download', ['archivo' => basename($archivo)]) }}" class="btn btn-success btn-sm">Descargar</a>
                <form action="{{ route('archivos.delete', ['archivo' => basename($archivo)]) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
@endsection
