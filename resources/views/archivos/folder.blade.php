@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Contenido de la Carpeta: {{ $carpeta }}</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Formulario para subir archivos -->
    <form action="{{ route('archivos.upload-to-folder', ['carpeta' => $carpeta]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="archivo" required>
        <button type="submit" class="btn btn-primary">Subir Archivo</button>
    </form>

    <!-- Formulario para crear subcarpetas -->
    <form action="{{ route('archivos.create-subfolder', ['carpeta' => $carpeta]) }}" method="POST">
        @csrf
        <input type="text" name="nombre_subcarpeta" placeholder="Nombre de la subcarpeta" required>
        <button type="submit" class="btn btn-info">Crear Subcarpeta</button>
    </form>

    <!-- Lista de archivos -->
    <h2>Archivos</h2>
    @if (count($archivos) > 0)
        <ul class="file-list">
            @foreach ($archivos as $archivo)
                <li>
                    {{ basename($archivo) }}
                    <a href="{{ route('archivos.download-from-folder', ['carpeta' => $carpeta, 'archivo' => basename($archivo)]) }}" class="btn btn-success btn-sm">Descargar</a>
                    <form action="{{ route('archivos.delete-from-folder', ['carpeta' => $carpeta, 'archivo' => basename($archivo)]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p>No hay archivos en esta carpeta.</p>
    @endif

    <!-- Lista de subcarpetas -->
    <h2>Subcarpetas</h2>
    @if (count($subcarpetas) > 0)
        <ul class="folder-list">
            @foreach ($subcarpetas as $subcarpeta)
                <li>
                    <a href="{{ route('archivos.open-folder', ['carpeta' => rawurlencode($carpeta . '/' . basename($subcarpeta))]) }}">
                        {{ basename($subcarpeta) }}
                    </a>
                    <form action="{{ route('archivos.delete-folder', ['carpeta' => $carpeta . '/' . basename($subcarpeta)]) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @else
        <p>No hay subcarpetas en esta carpeta.</p>
    @endif

    <!-- Breadcrumb para navegar entre carpetas -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('ruta.archivos') }}">Inicio</a></li>
            @php
                $rutaActual = '';
                $partesRuta = explode('/', $carpeta);
            @endphp
            @foreach ($partesRuta as $parte)
                @php
                    $rutaActual .= $parte . '/';
                @endphp
                <li class="breadcrumb-item">
                    <a href="{{ route('archivos.open-folder', ['carpeta' => rtrim($rutaActual, '/')]) }}">
                        {{ $parte }}
                    </a>
                </li>
            @endforeach
        </ol>
    </nav>

    <!-- Botón para volver a la carpeta anterior -->
    @php
        $carpetaPadre = dirname($carpeta);
    @endphp
    @if ($carpetaPadre === null || $carpetaPadre === '.')
    <a href="{{ route('ruta.archivos') }}" class="btn btn-secondary">Volver</a>
@else
    <a href="{{ route('archivos.open-folder', ['carpeta' => $carpetaPadre]) }}" class="btn btn-secondary">Volver</a>
@endif
</div>
<script>
    document.querySelectorAll('a[href*="open-folder"]').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const path = this.getAttribute('href');
            window.location.href = decodeURIComponent(path);
        });
    });
    </script>
@endsection
