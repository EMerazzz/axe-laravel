@extends('adminlte::page')

@section('title', 'AXE')

@section('content_header')
<center>
    <h1>Detalles teléfonos</h1>
</center>
<blockquote class="blockquote text-center">
    <p class="mb-0">Teléfonos registrados en el sistema AXE.</p>
    <footer class="blockquote-footer">Teléfonos <cite title="Source Title">Completados</cite></footer>
</blockquote>
@stop

@section('content')
<button type="button" class="btn btn-success" data-toggle="modal" data-target="#telefonos">+ Nuevo</button>

<div class="modal fade bd-example-modal-sm" id="telefonos" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ingresa un nuevo Teléfono</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Ingrese los Datos:</p>
            </div>
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{ url('telefonos/insertar') }}" method="post">
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
                            <label for="TELEFONO" class="form-label">Número de teléfono</label>
                            <input type="text" class="form-control" id="TELEFONO" name="TELEFONO" placeholder="Ingrese el número de teléfono">
                        </div>
                        <div class="mb-3">
                            <label for="TIPO_TELEFONO" class="form-label">Tipo de teléfono:</label>
                            <select class="form-select" id="TIPO_TELEFONO" name="TIPO_TELEFONO">
                                <option value="Fijo" selected>Fijo</option>
                                <option value="Movil">Móvil</option>
                            </select>
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
                <th>Código teléfono</th>
                <th>Código persona</th>
                <th>Nombre completo</th>
                <th>Número de Teléfono</th>
                <th>Tipo de Teléfono</th>
                <th>Fecha de registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($telefonosArreglo as $telefonos)
                @php
                    $persona = null;
                    foreach ($personasArreglo as $p) {
                        if ($p['COD_PERSONA'] === $telefonos['COD_PERSONA']) {
                            $persona = $p;
                            break;
                        }
                    }
                @endphp
                <tr>
                    <td>{{ $telefonos['COD_TELEFONO'] }}</td>
                    <td>{{ $telefonos['COD_PERSONA'] }}</td>
                    <td>
                        @if ($persona !== null)
                            {{ $persona['NOMBRE'] . ' ' . $persona['APELLIDO'] }}
                        @else
                            Persona no encontrada
                        @endif
                    </td>
                    <td>{{ $telefonos['TELEFONO'] }}</td>
                    <td>{{ $telefonos['TIPO_TELEFONO'] }}</td>
                    <td>{{ date('d, M Y', strtotime($telefonos['FECHA'])) }}</td>
                    <td>
                        <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal"
                            data-target="#telefonos-edit-{{ $telefonos['COD_TELEFONO'] }}">
                            <i class="fas fa-edit" style="font-size: 13px; color: cyan;"></i> Editar
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>



@foreach($telefonosArreglo as $telefonos)
<div class="modal fade bd-example-modal-sm" id="telefonos-edit-{{ $telefonos['COD_TELEFONO'] }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualiza el teléfono seleccionado</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Ingresa los Nuevos Datos</p>
            </div>
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{ url('telefonos/actualizar') }}" method="post">
                        @csrf
                        <input type="hidden" class="form-control" name="COD_TELEFONO" value="{{ $telefonos['COD_TELEFONO'] }}">
                        <div class="mb-3 mt-3">
                            <label for="TELEFONO" class="form-label">Número de teléfono</label>
                            <input type="text" class="form-control" id="TELEFONO" name="TELEFONO" placeholder="Ingrese el número de teléfono"value="{{ $telefonos['TELEFONO'] }}">
                        </div>
                        <div class="mb-3">
                            <label for="TIPO_TELEFONO" class="form-label">Tipo Telefono:</label>
                            <select class="form-select" id="TIPO_TELEFONO" name="TIPO_TELEFONO">
                                <option value="Fijo" {{ $telefonos['TIPO_TELEFONO'] === 'Fijo' ? 'selected' : '' }}>Fijo</option>
                                <option value="Movil" {{ $telefonos['TIPO_TELEFONO'] === 'Movil' ? 'selected' : '' }}>Movil</option>
                            </select>
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