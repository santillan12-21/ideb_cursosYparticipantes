@extends('layouts.app')

@section('content')
    <div class="container">
        <!-- Título de la sección -->
        <h3 class="text-center mt-5">Participantes Inscritos</h3>

        <!-- Botón para Mostrar/Ocultar Filtros -->
        <div class="text-center mb-4">
            <button id="toggleFilters" class="btn btn-primary">Mostrar/Ocultar Filtros</button>
        </div>

        <!-- Contenedor de Filtros (oculto inicialmente) -->
        <div id="filtersContainer" class="row mb-4" style="display: none;">
            <div class="col-md-12">
                <form action="{{ route('participantes.filtrar') }}" method="GET" class="form-inline">
                    <!-- Filtro por Curso -->
                    <div class="form-group mr-3">
                        <label for="curso" class="mr-2">Curso:</label>
                        <select name="curso" id="curso" class="form-control">
                            <option value="">Todos los Cursos</option>
                            @foreach($cursos as $curso)
                                <option value="{{ $curso->id }}" {{ request('curso') == $curso->id ? 'selected' : '' }}>
                                    {{ $curso->NombredelCurso }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filtro por Estado de Pago -->
                    <div class="form-group mr-3">
                        <label for="estado_pago" class="mr-2">Estado de Pago:</label>
                        <select name="estado_pago" id="estado_pago" class="form-control">
                            <option value="">Todos</option>
                            <option value="Pagado" {{ request('estado_pago') == 'Pagado' ? 'selected' : '' }}>Pagado</option>
                            <option value="Pendiente" {{ request('estado_pago') == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="Anticipo" {{ request('estado_pago') == 'Anticipo' ? 'selected' : '' }}>Anticipo</option>
                            <option value="Cancelado" {{ request('estado_pago') == 'Cancelado' ? 'selected' : '' }}>Cancelado</option>
                        </select>
                    </div>

                    <!-- Filtro por Rango de Costo -->
                    <div class="form-group mr-3">
                        <label for="min_costo" class="mr-2">Costo Mínimo:</label>
                        <input type="text" name="min_costo" id="min_costo" class="form-control"
                            placeholder="Mínimo" value="{{ request('min_costo') }}">
                    </div>
                    <div class="form-group mr-3">
                        <label for="max_costo" class="mr-2">Costo Máximo:</label>
                        <input type="text" name="max_costo" id="max_costo" class="form-control"
                            placeholder="Máximo" value="{{ request('max_costo') }}">
                    </div>

                    <!-- Filtro de busqueda -->
                    <div class="form-group mr-3 position-relative">
                        <label for="busqueda" class="mr-2">Búsqueda General:</label>
                        <div class="d-flex align-items-center">
                            <input type="text" name="busqueda" id="busqueda" class="form-control"
                                placeholder="Buscar por nombre, correo, teléfono, empresa..."
                                value="{{ request('busqueda') }}">
                            <div class="ml-2 position-relative"
                                 data-toggle="tooltip"
                                 data-placement="right"
                                 title="Puedes buscar toda la información de la tabla, a excepción de pago y cursos.
                                    Puedes usar mayúsculas y minúsculas.
                                    Para regresar a la tabla completa, solo borra lo que escribiste y dale clic a filtrar.
                                 ">
                                <i class="fas fa-question-circle text-primary" style="font-size: 1.2rem; cursor: help;"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Botón para Aplicar Filtros -->
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </form>
            </div>
        </div>

        <!-- Contenedor responsivo para la tabla -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover mx-auto" style="width: 100%; max-width: 1200px;">
                <thead class="table-dark">
                    <tr>
                        <th>N</th>
                        <th>Nombre del Postulante</th>
                        <th>Correo</th>
                        <th>Teléfono</th>
                        <th>Edad</th>
                        <th>Dirección</th>
                        <th>Escolaridad</th>
                        <th>CURP</th>
                        <th>Razón Social</th>
                        <th>Empresa</th>
                        <th>RFC Empresa</th>
                        <th>Puesto</th>
                        <th>Pago</th>
                        <th>Estado de Pago</th>
                        <th>Fecha del Curso</th>
                        <th>Cursos Inscritos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($participantes as $participante)
                    <tr>
                        <!-- Información del participante -->
                        <td>{{ $participante->N }}</td>
                        <td>{{ $participante->NombredelPostulante }}</td>
                        <td>{{ $participante->Correo }}</td>
                        <td>{{ $participante->Telefono }}</td>
                        <td>{{ $participante->Edad }}</td>
                        <td>{{ $participante->Direccion }}</td>
                        <td>{{ $participante->Escolaridad }}</td>
                        <td>{{ $participante->Curp }}</td>
                        <td>{{ $participante->RazónSocial }}</td>
                        <td>{{ $participante->Empresa }}</td>
                        <td>{{ $participante->RFCEmpresa }}</td>
                        <td>{{ $participante->Puesto }}</td>
                        <td>${{ number_format($participante->Pago, 2) }}</td>
                        <td>{{ $participante->EstadoDePago }}</td>
                        <td>{{ $participante->FechadelCurso }}</td>
                        <td>
                            @if($participante->cursos->isEmpty())
                                <span>No hay cursos inscritos</span>
                            @else
                                @foreach($participante->cursos as $curso)
                                    {{ $curso->NombredelCurso }} ({{ $curso->pivot->FechadelCurso }})<br/>
                                @endforeach
                            @endif
                        </td>
                        <!-- Acciones (Editar y Eliminar) -->
                        <td>
                            <!-- Botón Editar -->
                            <a href="{{ route('participantes.edit', ['id' => $participante->id]) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <!-- Botón Eliminar -->
                            <form action="{{ route('participantes.destroy', ['id' => $participante->id]) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar este participante?')">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="16" class="text-center">No hay participantes inscritos con los filtros aplicados.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Script para Mostrar/Ocultar Filtros -->
    <script>
    document.getElementById('toggleFilters').addEventListener('click', function() {
        var filtersContainer = document.getElementById('filtersContainer');
        if (filtersContainer.style.display === 'none') {
            filtersContainer.style.display = 'block';
        } else {
            filtersContainer.style.display = 'none';
        }
    });
        $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip({
            html: true,
            template: '<div class="tooltip" role="tooltip"><div class="arrow"></div><div class="tooltip-inner text-left"></div></div>'
        });
    });
    </script>

@endsection
