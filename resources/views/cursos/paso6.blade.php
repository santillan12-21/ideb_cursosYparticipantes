@extends('layouts.app')

@section('content')
<div class="container" style="margin-top:150px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3>PRUEBA DE FORMULARIO</h3>
                </div>
                <div class="card-body">
                    <form action="/curso/paso6-test" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="Prueba">
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection