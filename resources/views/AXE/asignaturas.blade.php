@extends('adminlte::page')

@section('title', 'AXE')
@section('content_header')
    <center>
        <h1>Detalles asignaturas</h1>
    </center>
    <blockquote class="blockquote text-center">
        <p class="mb-0">Asignaturas registradas en el sistema AXE.</p>
        <footer class="blockquote-footer">Existencia <cite title="Source Title">Completados</cite></footer>
    </blockquote>
@stop

@section('content')
    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#asignaturas-modal">+ Nuevo</button>
    
    <div class="modal fade bd-example-modal-sm" id="asignaturas-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ingresa una Nueva Asignatura</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Ingrese los Datos:</p>
                    <form action="{{ url('asignaturas/insertar') }}" method="post">
                        @csrf
                        <div class="mb-3 mt-3">
                            <label for="NOMBRE_ASIGNATURA" class="form-label">Nombre de la Asignatura</label>
                            <input type="text" class="form-control" id="NOMBRE_ASIGNATURA" name="NOMBRE_ASIGNATURA" placeholder="Ingrese la asignatura">
                        </div>
                        <button type="submit" class="btn btn-primary">Añadir</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-dark table-striped mt-1" style="border: 2px solid lime;">
            <thead>
                <tr>
                    <th>Código Asignatura</th> 
                    <th>Nombre Asignatura</th> 
                    <th>Opciones de la Tabla</th>
                </tr>
            </thead>
            <tbody>
                @foreach($citaArreglo as $asignatura)
                    <tr>
                        <td>{{ $asignatura['COD_ASIGNATURA'] }}</td>
                        <td>{{ $asignatura['NOMBRE_ASIGNATURA'] }}</td>
                        <td>
                            <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#asignaturas-edit-{{ $asignatura['COD_ASIGNATURA'] }}">
                                <i class='fas fa-edit' style='font-size:13px;color:cyan'></i> Editar
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach($citaArreglo as $asignatura)
        <div class="modal fade bd-example-modal-sm" id="asignaturas-edit-{{ $asignatura['COD_ASIGNATURA'] }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Actualiza la asignatura seleccionada</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Ingrese los Nuevos Datos</p>
                        <form action="{{ url('asignaturas/actualizar') }}" method="post">
                            @csrf
                            <input type="hidden" class="form-control" name="COD_ASIGNATURA" value="{{ $asignatura['COD_ASIGNATURA'] }}">
                            <div class="mb-3 mt-3">
                                <label for="NOMBRE_ASIGNATURA" class="form-label">Nombres de la Asignatura</label>
                                <input type="text" class="form-control" id="NOMBRE_ASIGNATURA" name="NOMBRE_ASIGNATURA" placeholder="Ingrese la asignatura" value="{{ $asignatura['NOMBRE_ASIGNATURA'] }}">
                            </div>
                            <!-- ... otros campos del formulario ... -->
                            <button type="submit" class="btn btn-primary">Editar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
