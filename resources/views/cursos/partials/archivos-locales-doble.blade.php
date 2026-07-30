@php
    $recursoKey2 = $recursoKey . '_2';
    $archivo1 = $recursos[$recursoKey] ?? null;
    $archivo2 = $recursos[$recursoKey2] ?? null;
@endphp

<div class="col-12">
    <label class="form-label">
        Archivos locales
        <small class="text-muted fw-normal">(opcional, hasta 2)</small>
    </label>

    <div class="mb-3">
        <label class="form-label small text-muted mb-1">Archivo 1</label>
        <input type="file" name="{{ $inputName }}" class="form-control">
        @if($archivo1)
            <div class="documento-preview">
                <i class="fas fa-file-alt"></i>
                <span class="doc-nombre">{{ basename($archivo1->url) }}</span>
                <div class="doc-acciones">
                    <a href="{{ $archivo1->archivo_publico_url }}" target="_blank" class="btn-ver-doc">
                        <i class="fas fa-eye"></i> Ver
                    </a>
                </div>
            </div>
        @endif
    </div>

    <div>
        <label class="form-label small text-muted mb-1">Archivo 2</label>
        <input type="file" name="{{ $inputName }}2" class="form-control">
        @if($archivo2)
            <div class="documento-preview">
                <i class="fas fa-file-alt"></i>
                <span class="doc-nombre">{{ basename($archivo2->url) }}</span>
                <div class="doc-acciones">
                    <a href="{{ $archivo2->archivo_publico_url }}" target="_blank" class="btn-ver-doc">
                        <i class="fas fa-eye"></i> Ver
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
