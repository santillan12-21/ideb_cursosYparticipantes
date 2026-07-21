@extends('home')
@section('title', '- Carpeta de Drive')

@section('content')
<style>
    .drive-container {
        max-width: 1100px;
        margin: 20px auto;
        padding: 20px;
    }
    .drive-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .drive-header {
        background: linear-gradient(135deg, #212529 0%, #343a40 100%);
        color: #fff;
        padding: 24px 28px;
    }
    .drive-table th {
        background: #f8f9fa;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .drive-name {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: #212529;
        text-decoration: none;
        font-weight: 600;
    }
    .drive-name:hover {
        color: #0d6efd;
    }
    .breadcrumb-item a {
        text-decoration: none;
    }
</style>

<div class="drive-container">
    <div class="card drive-card">
        <div class="drive-header d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h1 class="h3 mb-1"><i class="fa-brands fa-google-drive me-2"></i>Carpeta de Drive</h1>
                <p class="mb-0 opacity-75">Acceso directo desde la aplicación, sin iniciar sesión en Google.</p>
            </div>
            @if($externalUrl)
                <a href="{{ $externalUrl }}" target="_blank" rel="noopener noreferrer" class="btn btn-outline-light btn-sm">
                    <i class="fa-solid fa-up-right-from-square me-1"></i> Abrir en Google Drive
                </a>
            @endif
        </div>

        <div class="card-body p-4">
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($error)
                <div class="alert alert-danger">{{ $error }}</div>
            @endif

            @if(!empty($breadcrumbs))
                <nav aria-label="breadcrumb" class="mb-4">
                    <ol class="breadcrumb mb-0">
                        @foreach($breadcrumbs as $crumb)
                            @if($loop->last)
                                <li class="breadcrumb-item active" aria-current="page">{{ $crumb['name'] }}</li>
                            @else
                                <li class="breadcrumb-item">
                                    <a href="{{ route('drive.index', ['folder' => $crumb['id']]) }}">{{ $crumb['name'] }}</a>
                                </li>
                            @endif
                        @endforeach
                    </ol>
                </nav>
            @endif

            @if(!$error)
                <div class="table-responsive">
                    <table class="table table-hover align-middle drive-table">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Modificado</th>
                                <th>Tamaño</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $item)
                                <tr>
                                    <td>
                                        @if($item['isFolder'])
                                            <a href="{{ route('drive.index', ['folder' => $item['id']]) }}" class="drive-name">
                                                <i class="fa-solid fa-folder text-warning"></i>
                                                {{ $item['name'] }}
                                            </a>
                                        @else
                                            <span class="drive-name">
                                                <i class="fa-solid fa-file-lines text-secondary"></i>
                                                {{ $item['name'] }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ $item['modifiedTime'] ? \Carbon\Carbon::parse($item['modifiedTime'])->format('d/m/Y H:i') : '-' }}</td>
                                    <td>
                                        @if($item['isFolder'])
                                            Carpeta
                                        @elseif($item['size'])
                                            {{ number_format($item['size'] / 1024, 1) }} KB
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        @if($item['isFolder'])
                                            <a href="{{ route('drive.index', ['folder' => $item['id']]) }}" class="btn btn-sm btn-outline-primary">
                                                Abrir
                                            </a>
                                        @else
                                            <a href="{{ route('drive.open', $item['id']) }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                                Ver
                                            </a>
                                            <a href="{{ route('drive.download', $item['id']) }}" class="btn btn-sm btn-outline-secondary">
                                                Descargar
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-muted">Esta carpeta está vacía.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
