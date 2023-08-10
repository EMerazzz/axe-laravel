@extends('adminlte::page')

@section('title', 'AXE')

@section('content_header')
<center>
    <h1>Detalles direcciones</h1>
</center>
<blockquote class="blockquote text-center">
    <p class="mb-0">Direcciones registradas en el sistema AXE.</p>
    <footer class="blockquote-footer">Direcciones <cite title="Source Title">Completados</cite></footer>
</blockquote>
@stop

@section('content')
<style>
    .same-width {
        width: 100%; /* El combobox ocupará el mismo ancho que el textbox */
    }
</style>

<style>
    .btn-custom {
        margin-top: 10px; /* Ajusta el valor según tus necesidades */
    }
</style>
<style>
    .spacer {
        height: 20px; /* Ajusta la altura según tus necesidades */
    }
</style>
<div class="spacer"></div>
<button type="button" class="btn btn-success btn-custom" data-toggle="modal" data-target="#personas">+ Nuevo</button>
<div class="spacer"></div>
<div class="modal fade bd-example-modal-sm" id="personas" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ingresa una nueva direccion</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Ingrese los Datos:</p>
            </div>
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{ url('direcciones/insertar') }}" method="post">
                        @csrf
                        <!-- INICIO --->
                        <div class="mb-3 mt-3">
                            <label for="COD_PERSONA" class="form-label">Persona: </label>
                            <select class="form-control same-width" id="COD_PERSONA" name="COD_PERSONA" required>
                                <option value="" disabled selected>Seleccione una persona</option>
                                @foreach ($personasArreglo as $persona)
                                    <option value="{{ $persona['COD_PERSONA'] }}">{{ $persona['NOMBRE'] }} {{ $persona['APELLIDO'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- FIN --->
                        <div class="mb-3 mt-3">
                            <label for="direcciones" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="DIRECCION" name="DIRECCION" placeholder="Ingrese la dirección">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="direcciones" class="form-label">Departamento</label>
                            <input type="text" class="form-control" id="DEPARTAMENTO" name="DEPARTAMENTO" placeholder="Ingrese el departamento">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="direcciones" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" id="CIUDAD" name="CIUDAD" placeholder="Ingrese la ciudad">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="direcciones" class="form-label">País</label>
                            <input type="text" class="form-control" id="PAIS" name="PAIS" placeholder="Ingrese el pais">
                        </div>
                
                        <button type="submit" class="btn btn-primary">Añadir</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<table id="miTabla" class="table table-hover table-dark table-striped mt-1" style="border:2px solid lime;">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre completo</th>
                <th>Dirección</th>
                <th>Departamento</th>
                <th>Ciudad</th>
                <th>Pais</th>
                <th>Fecha de registro</th>
                <th>Opciones de la Tabla</th>
            </tr>
        </thead>
        <tbody>
            @foreach($direccionesArreglo as $direcciones)
            @php
                    $persona = null;
                    foreach ($personasArreglo as $p) {
                        if ($p['COD_PERSONA'] === $direcciones['COD_PERSONA']) {
                            $persona = $p;
                            break;
                        }
                    }
                @endphp
            <tr>
                <td>{{ $direcciones['COD_DIRECCION'] }}</td>
                <td>
                        @if ($persona !== null)
                            {{ $persona['NOMBRE'] . ' ' . $persona['APELLIDO'] }}
                        @else
                            Persona no encontrada
                        @endif
                    </td>
                <td>{{ $direcciones['DIRECCION'] }}</td>
                <td>{{ $direcciones['DEPARTAMENTO'] }}</td>
                <td>{{ $direcciones['CIUDAD'] }}</td>
                <td>{{ $direcciones['PAIS'] }}</td>
                <td>{{ date('d, M Y', strtotime($direcciones['FECHA'])) }}</td>
                <td>
                    <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal"
                        data-target="#direcciones-edit-{{ $direcciones['COD_DIRECCION'] }}">
                        <i class="fas fa-edit" style="font-size: 13px; color: cyan;"></i> Editar
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@foreach($direccionesArreglo as $direcciones)
<div class="modal fade bd-example-modal-sm" id="direcciones-edit-{{ $direcciones['COD_DIRECCION'] }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualiza la dirección seleccionada</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Ingresa los Nuevos Datos</p>
            </div>
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{ url('direcciones/actualizar') }}" method="post">
                        @csrf
                        <input type="hidden" class="form-control" name="COD_DIRECCION" value="{{ $direcciones['COD_DIRECCION'] }}">
                        <div class="mb-3 mt-3">
                            <label for="direcciones" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="DIRECCION" name="DIRECCION" placeholder="Ingrese la dirección" value="{{ $direcciones['DIRECCION'] }}">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="direcciones" class="form-label">Departamento</label>
                            <input type="text" class="form-control" id="DEPARTAMENTO" name="DEPARTAMENTO" placeholder="Ingrese el departamento" value="{{ $direcciones['DEPARTAMENTO'] }}">
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="direcciones" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" id="CIUDAD" name="CIUDAD" placeholder="Ingrese la ciudad" value="{{ $direcciones['CIUDAD'] }}">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="direcciones" class="form-label">país</label>
                            <input type="text" class="form-control" id="PAIS" name="PAIS" placeholder="Ingrese el país" value="{{ $direcciones['PAIS'] }}">
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
    <!-- Agregar estilos para DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@stop

@section('js')
    
    <script> console.log('Hi!'); </script>
    <!-- Agregar scripts para DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <!-- Script personalizado para inicializar DataTables -->
    <script>
        $(document).ready(function() {
            $('#miTabla').DataTable({

              "language":{
             "search":       "Buscar: ",
             "lengthMenu":   "Mostrar _MENU_ registros por página",
             "info":   "Mostrando página _PAGE_ de _PAGES_",
             "paginate": {"previous": "Anterior",
                          "next":  "Siguiente",
                          "first": "Primero",
                          "last":  ""


             }
            }
          });
        });

    </script>
@stop
