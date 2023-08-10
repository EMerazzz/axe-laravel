@extends('adminlte::page')

@section('title', 'AXE')
@section('content_header')

<center>
    <h1>Detalles Docentes</h1>
</center>
<blockquote class="blockquote text-center">
    <p class="mb-0">Docentes registradss en el sistema AXE.</p>
    <footer class="blockquote-footer">Docentes <cite title="Source Title">Completados</cite></footer>
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
        margin-top: 5px; /* Ajusta el valor según tus necesidades */
    }
</style>
<style>
    .spacer {
        height: 20px; /* Ajusta la altura según tus necesidades */
    }
    
</style>
<style>
        /* Agrega el estilo para mostrar el mensaje de ayuda cuando el campo es inválido */
        input:invalid {
            border-color: red; /* Cambia el color del borde si el campo es inválido */
        }

        /* Personaliza el estilo del mensaje de ayuda */
        input:invalid::before {
            content: attr(title); /* Usa el atributo title como contenido del mensaje */
            color: red;
            display: block;
            padding: 5px;
        }
    </style>

 @if(session('success'))
<div class="alert alert-success mt-2">
    {{ session('success') }}
</div>
@endif

@if(session('error'))
<div class="alert alert-danger mt-2">
    {{ session('error') }}
</div>
@endif 

<div class="spacer"></div>
<button type="button" class="btn btn-success btn-custom" data-toggle="modal" data-target="#docentes">+ Nuevo</button>
<div class="spacer"></div>
<div class="modal fade bd-example-modal-sm" id="docentes" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ingresa un nuevo docente</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Ingrese los Datos:</p>
            </div>
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{url('docentes/insertar')}}" method="post">
                        @csrf
                 <!-- INICIO --->
                 <div class="mb-3 mt-3">
    <label for="COD_PERSONA" class="form-label">Persona: </label>
    <select class="form-control same-width" id="COD_PERSONA" name="COD_PERSONA" required>
        <option value="" disabled selected>Seleccione una persona</option>
        @foreach ($personasArreglo as $persona)
            @if ($persona['TIPO_PERSONA'] === 'Docente')
                <option value="{{ $persona['COD_PERSONA'] }}">{{ $persona['NOMBRE'] }} {{ $persona['APELLIDO'] }}</option>
            @endif
        @endforeach
    </select>
</div>
                        <div class="mb-3 mt-3">
                            <label for="docentes" class="form-label">Especialidad</label>
                            <input type="text" class="form-control" id="ESPECIALIDAD" name="ESPECIALIDAD" placeholder="Ingrese la especialidad del docente"pattern="^[A-Za-záéíóúÁÉÍÓÚñÑ ]+$" title="Solo se permiten letras y espacios" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="docentes" class="form-label">Grado enseñanza</label>
                            <input type="text" class="form-control" id="GRADO_ENSENIANZA" name="GRADO_ENSENIANZA" placeholder="Ingrese el grado de enseñanza"pattern="^[A-Za-záéíóúÁÉÍÓÚñÑ ]+$" title="Solo se permiten letras y espacios" required>
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
                <th>Especialidad</th>
                <th>Grado enseñanza</th>
                <th>Opciones de la Tabla</th>
            </tr>
        </thead>
        <tbody>
            @foreach($docentesArreglo as $docentes)
            @php
                    $persona = null;
                    foreach ($personasArreglo as $p) {
                        if ($p['COD_PERSONA'] === $docentes['COD_PERSONA']) {
                            $persona = $p;
                            break;
                        }
                    }
                @endphp
            <tr>
                <td>{{ $docentes['COD_DOCENTE'] }}</td>
                <td>
                        @if ($persona !== null)
                            {{ $persona['NOMBRE'] . ' ' . $persona['APELLIDO'] }}
                        @else
                            Persona no encontrada
                        @endif
                </td>

                 <td>{{ $docentes['ESPECIALIDAD'] }}</td>
               
                    <td>{{ $docentes['GRADO_ENSENIANZA'] }}</td>
                <td>
                    <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal"
                        data-target="#docentes-edit-{{ $docentes['COD_DOCENTE'] }}">
                        <i class="fas fa-edit" style="font-size: 13px; color: cyan;"></i> Editar
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@foreach($docentesArreglo as $docentes)
<div class="modal fade bd-example-modal-sm" id="docentes-edit-{{ $docentes['COD_DOCENTE'] }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualiza el docente seleccionado</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Ingresa los Nuevos Datos</p>
            </div>
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{ url('docentes/actualizar') }}" method="post">
                        @csrf
                        <input type="hidden" class="form-control" name="COD_DOCENTE" value="{{ $docentes['COD_DOCENTE'] }}">
                        <div class="mb-3 mt-3">
                            <label for="docentes" class="form-label">Especialidad</label>
                            <input type="text" class="form-control" id="ESPECIALIDAD" name="ESPECIALIDAD" placeholder="Ingrese el correo electrónico" value="{{ $docentes['ESPECIALIDAD'] }}">
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="docentes" class="form-label">Grado de enseñanza</label>
                            <input type="text" class="form-control" id="GRADO_ENSENIANZA" name="GRADO_ENSENIANZA" placeholder="Ingrese el correo electrónico" value="{{ $docentes['GRADO_ENSENIANZA'] }}">
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