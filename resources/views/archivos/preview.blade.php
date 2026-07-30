@extends('home')
@section('title', '- Vista previa')
@section('content')

<style>
    .preview-container {
        max-width: 1100px;
        margin: 20px auto;
        padding: 0 20px 40px;
    }
    .preview-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        margin-bottom: 16px;
    }
    .preview-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        padding: 24px;
        min-height: 300px;
    }
    .preview-loading {
        text-align: center;
        color: #6c757d;
        padding: 40px 0;
    }
    .preview-content {
        overflow-x: auto;
    }
    .preview-content table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.95rem;
    }
    .preview-content table td,
    .preview-content table th {
        border: 1px solid #dee2e6;
        padding: 6px 10px;
        vertical-align: top;
    }
    .preview-content img {
        max-width: 100%;
        height: auto;
    }
    .preview-note {
        background: #f8f9fa;
        border-left: 4px solid #0d6efd;
        padding: 12px 16px;
        margin-bottom: 16px;
        border-radius: 0 8px 8px 0;
    }
</style>

<div class="preview-container">
    <div class="preview-toolbar">
        <div>
            <h2 class="h4 mb-1">Vista previa</h2>
            <p class="text-muted mb-0">{{ $nombre }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ $volverUrl }}" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-1"></i> Volver
            </a>
            <a href="{{ $downloadUrl }}" class="btn btn-success">
                <i class="fas fa-download me-1"></i> Descargar
            </a>
        </div>
    </div>

    <div class="preview-card">
        @if (!empty($sinPreview))
            <div class="alert alert-warning mb-0">
                Este tipo de archivo (<strong>.{{ $extension }}</strong>) no se puede previsualizar en el navegador.
                Usa <strong>Descargar</strong> para abrirlo con Word, Excel u otra aplicación.
            </div>
        @else
            <div class="preview-note">
                Vista previa aproximada. Puede diferir del formato original en Word o Excel.
            </div>
            <div id="preview-loading" class="preview-loading">
                <i class="fas fa-spinner fa-spin me-2"></i> Cargando vista previa...
            </div>
            <div id="preview-error" class="alert alert-danger d-none"></div>
            <div id="preview-content" class="preview-content"></div>
        @endif
    </div>
</div>

@if (empty($sinPreview))
    @if ($extension === 'docx')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/mammoth/1.6.0/mammoth.browser.min.js"></script>
    @elseif (in_array($extension, ['xls', 'xlsx']))
        <script src="https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js"></script>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', async function () {
            const extension = @json($extension);
            const streamUrl = @json($streamUrl);
            const loading = document.getElementById('preview-loading');
            const errorBox = document.getElementById('preview-error');
            const content = document.getElementById('preview-content');

            try {
                const response = await fetch(streamUrl);
                if (!response.ok) {
                    throw new Error('No se pudo cargar el archivo.');
                }

                const buffer = await response.arrayBuffer();

                if (extension === 'docx') {
                    const result = await mammoth.convertToHtml({ arrayBuffer: buffer });
                    content.innerHTML = result.value || '<p class="text-muted">El documento está vacío.</p>';

                    if (result.messages.length > 0) {
                        console.warn('Advertencias al convertir DOCX:', result.messages);
                    }
                } else if (extension === 'xls' || extension === 'xlsx') {
                    const workbook = XLSX.read(buffer, { type: 'array' });

                    if (!workbook.SheetNames.length) {
                        content.innerHTML = '<p class="text-muted">La hoja de cálculo está vacía.</p>';
                    } else {
                        const sheetName = workbook.SheetNames[0];
                        const sheet = workbook.Sheets[sheetName];
                        content.innerHTML = `
                            <p class="text-muted small mb-2">Hoja: <strong>${sheetName}</strong></p>
                            ${XLSX.utils.sheet_to_html(sheet)}
                        `;
                    }
                }

                loading.classList.add('d-none');
            } catch (error) {
                loading.classList.add('d-none');
                errorBox.textContent = error.message || 'Ocurrió un error al generar la vista previa.';
                errorBox.classList.remove('d-none');
            }
        });
    </script>
@endif

@endsection
