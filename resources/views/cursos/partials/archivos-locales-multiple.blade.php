@php
    $cantidad = $cantidad ?? 1;
    $recursoKeyBase = $recursoKey;
@endphp

<div class="col-12">
    <label class="form-label">
        Archivos locales
        <small class="text-muted fw-normal">(opcional, hasta {{ $cantidad }})</small>
    </label>

    @for ($i = 1; $i <= $cantidad; $i++)
        @php
            $suffix = $i === 1 ? '' : (string) $i;
            $recursoKeyItem = $i === 1 ? $recursoKeyBase : $recursoKeyBase . '_' . $i;
            $archivo = $recursos[$recursoKeyItem] ?? null;
        @endphp
        <div class="apartado-archivo mb-3 p-3 border rounded bg-white">
            <label class="form-label small fw-bold mb-1">Apartado {{ $i }}</label>
            <input type="file" name="{{ $inputName }}{{ $suffix }}" class="form-control">
            @if($archivo)
                <div class="documento-preview mt-2">
                    <i class="fas fa-file-alt"></i>
                    <span class="doc-nombre">{{ basename($archivo->url) }}</span>
                    <div class="doc-acciones">
                        <a href="{{ $archivo->archivo_publico_url }}" target="_blank" class="btn-ver-doc">
                            <i class="fas fa-eye"></i> Ver
                        </a>
                    </div>
                </div>
            @endif
        </div>
    @endfor
</div>
