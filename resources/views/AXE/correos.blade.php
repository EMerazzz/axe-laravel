@extends('adminlte::page')

@section('title', 'AXE')

@section('content_header')
<center>
    <h1>Detalles Correos</h1>
</center>
<blockquote class="blockquote text-center">
    <p class="mb-0">Correos registrados en el sistema AXE.</p>
    <footer class="blockquote-footer">Correos <cite title="Source Title">Completados</cite></footer>
</blockquote>
@stop

@section('content')
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#correos">+ Nuevo</button>

<div class="modal fade bd-example-modal-sm" id="correos" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ingresa un nuevo correo</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>   
            <div class="modal-body">
                <p>Ingrese los Datos:</p>
            </div>
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{ url('correos/insertar') }}" method="post">
                        @csrf
                        <!-- INICIO --->
                        <div class="mb-3 mt-3">
                            <label for="COD_PERSONA" class="form-label">Persona: </label>
                            <select class="form-select" id="COD_PERSONA" name="COD_PERSONA" required>
                                <option value="" disabled selected>Seleccione una persona</option>
                                @foreach ($personasArreglo as $persona)
                                    <option value="{{ $persona['COD_PERSONA'] }}">{{ $persona['NOMBRE'] }} {{ $persona['APELLIDO'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- FIN --->
                        <div class="mb-3 mt-3">
                            <label for="correos" class="form-label">Correo Electrónico</label>
                            <input type="text" class="form-control" id="CORREO_ELECTRONICO" name="CORREO_ELECTRONICO" placeholder="Ingrese el correo electrónico">
                        </div>
                       
                        
                
                        <button type="submit" class="btn btn-primary">Añadir</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table cellspacing="10" cellpadding="10" class="table table-hover table-dark table-striped mt-1" style="border: 2px solid lime;">
        <thead>
            <tr>
                <th>Código correo</th>
                <th>Código persona</th>
                <th>Nombre completo</th>
                <th>Correo electrónico</th>
                <th>Fecha registro</th>
            </tr>
        </thead>
        <tbody>
            @foreach($correosArreglo as $correos)
            @php
                    $persona = null;
                    foreach ($personasArreglo as $p) {
                        if ($p['COD_PERSONA'] === $correos['COD_PERSONA']) {
                            $persona = $p;
                            break;
                        }
                    }
                @endphp
            <tr>
                <td>{{ $correos['COD_CORREO'] }}</td>
                <td>{{ $correos['COD_PERSONA'] }}</td>
                <td>
                        @if ($persona !== null)
                            {{ $persona['NOMBRE'] . ' ' . $persona['APELLIDO'] }}
                        @else
                            Persona no encontrada
                        @endif
                    </td>
                <td>{{ $correos['CORREO_ELECTRONICO'] }}</td>
               
                <td>{{ date('d, M Y', strtotime($correos['FECHA'])) }}</td>
                <td>
                    <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal"
                        data-target="#correos-edit-{{ $correos['COD_CORREO'] }}">
                        <i class="fas fa-edit" style="font-size: 13px; color: cyan;"></i> Editar
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@foreach($correosArreglo as $correos)
<div class="modal fade bd-example-modal-sm" id="correos-edit-{{ $correos['COD_CORREO'] }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualiza el correo seleccionado</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Ingresa los Nuevos Datos</p>
            </div>
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{ url('correos/actualizar') }}" method="post">
                        @csrf
                        <input type="hidden" class="form-control" name="COD_CORREO" value="{{ $correos['COD_CORREO'] }}">
                        <div class="mb-3 mt-3">
                            <label for="correos" class="form-label">Correo electrónico</label>
                            <input type="text" class="form-control" id="CORREO_ELECTRONICO" name="CORREO_ELECTRONICO" placeholder="Ingrese el correo electrónico" value="{{ $correos['CORREO_ELECTRONICO'] }}">
                        </div>
        

                        <button type="submit" class="btn btn-primary">Editar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
