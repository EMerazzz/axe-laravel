@extends('adminlte::page')

@section('title', 'Matriculas')

@section('content_header')
<style>
  .custom-blockquote {
    line-height: 0; /* Reducción de la altura */
    margin-top: -5px; 
    margin-bottom:-5px; /* Reducción del espacio inferior del bloquequote */
  }
</style>
<blockquote class="custom-blockquote">
    <p class="mb-0">Estudiantes registrados en el sistema AXE.</p>
</blockquote>

@stop

@section('content')
<!-- Cambiar Modo
<div class="d-flex justify-content-end align-items-center">
    <button id="mode-toggle" class="btn btn-info ms-2">
        <i class="fas fa-adjust"></i> Cambiar Modo
    </button>
</div>--->

<!-- Agregar botones de Exportar 
<div class="d-flex justify-content-end align-items-center mt-3">
    <button id="export-pdf" class="btn btn-danger ms-2"onclick="generarPDF()">
        <i class="far fa-file-pdf"></i> Exportar a PDF
    </button>
    <div style="width: 10px;"></div> 
    <button id="export-excel" class="btn btn-success ms-2" onclick="exportToExcel()">
        <i class="far fa-file-excel"></i> Exportar a Excel
    </button>
</div>
-->


<style>
    .same-width {
        width: 100%; /* El combobox ocupará el mismo ancho que el textbox */
    }
</style>

<style>
    .btn-custom {
        margin-top: 0px; /* Ajusta el valor según tus necesidades */
    }
</style>

<style>
    .table-responsive {
        margin-top: 5px; /* Ajusta el valor según tus necesidades */
    }
</style>
@if (session('message'))
<div class="modal fade message-modal" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #325d64; color:white;">
                <h3 class="modal-title" id="messageModalLabel">Mensaje:</h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <!-- El botón "Cerrar" con la clase "btn-close" cierra el modal -->
            </div>
            <div class="modal-body" style="background-color: #c8dbff;">
                <center><h3 style="color: #333;">{{ session('message.text') }}</h3></center>
            </div>
        </div>
    </div>
</div>
@endif

<div class="spacer"></div>
<button id="botonNuevo" type="button" class="btn btn-success btn-custom" data-toggle="modal" data-target="#matricula">+Matricular</button>
<div class="spacer"></div>

<div class="modal fade bd-example-modal-sm" id="matricula" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ingresa Matricula</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ url('matricula/insertar') }}" method="post">
                @csrf
                <div class="modal-body" style="background-color: #fff; padding: 20px;">
                <div class="mb-3 mt-3 form-inline">
                    <label for="COD_PERSONA" class="form-label mr-2">Estudiante: </label>
                    <select class="selectize" id="COD_PERSONA" name="COD_PERSONA" required style="width: 300px;">
                        <option value="" disabled selected>Seleccione una persona</option>
                        @foreach ($personasArreglo as $persona)
                            @php
                                $matriculasColeccion = collect($matriculaArreglo);
                            @endphp

                            @if ($persona['TIPO_PERSONA'] === 'Estudiante' && !$matriculasColeccion->contains('COD_PERSONA', $persona['COD_PERSONA']))
                                <option value="{{ $persona['COD_PERSONA'] }}">{{ $persona['NOMBRE'] }} {{ $persona['APELLIDO'] }} - {{ $persona['IDENTIDAD'] }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>


                        <!-- FIN --->
                        <div class="mb-3 mt-3 form-inline">
                            <label for="COD_NIVEL_ACADEMICO" class="form-label mr-2">Nivel Adémico: </label>
                            <select class="selectize" id="COD_NIVEL_ACADEMICO" name="COD_NIVEL_ACADEMICO" required style="width: 300px;">
                                <option value="" disabled selected>Seleccione el nivel académico</option>
                                @foreach ($nivel_academicoArreglo as $nivel_academico)
                                    <option value="{{ $nivel_academico['COD_NIVEL_ACADEMICO'] }}"
                                            {{ old('COD_NIVEL_ACADEMICO') == $nivel_academico['COD_NIVEL_ACADEMICO'] ? 'selected' : '' }}>
                                        {{ $nivel_academico['descripcion'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                            <div class="mb-3 mt-3 form-inline">
                                <label for="COD_ANIO_ACADEMICO" class="form-label mr-2">Año Académico: </label>
                                <select class="selectize" id="COD_ANIO_ACADEMICO" name="COD_ANIO_ACADEMICO" required style="width: 300px;">
                                    <option value="" disabled selected>Seleccione el año académico</option>
                                    @foreach ($anio_academicoArreglo as $anio_academico)
                                        <option value="{{ $anio_academico['COD_ANIO_ACADEMICO'] }}"
                                                {{ old('COD_ANIO_ACADEMICO') == $anio_academico['COD_ANIO_ACADEMICO'] ? 'selected' : '' }}>
                                            {{ $anio_academico['descripcion'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3 mt-3 form-inline">
                            <label for="matricula" class="form-label mr-2">Estado Matricula:</label>
                            <select class="selectize" id="ESTADO_MATRICULA" name="ESTADO_MATRICULA" required style="width: 300px;">
                            <option value="Activo" {{ old('ESTADO_MATRICULA') == 'Activo' ? 'selected' : '' }}>Activo</option>
                            <option value="Inactivo"{{ old('ESTADO_MATRICULA') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            </div>

                            <div class="mb-3 mt-3 form-inline">
                        <label for="estudiantes" class="form-label mr-2">Jornada:</label>
                        <select class="selectize" id="JORNADA" name="JORNADA" required style="width: 300px;">
                            <option value="Matutina" {{ old('JORNADA_ESTUDIANTE') == 'Matutina' ? 'selected' : '' }}>Matutina</option>
                            <option value="Vespertina"{{ old('JORNADA_ESTUDIANTE') == 'Vespertina' ? 'selected' : '' }}>Vespertina</option>
                            <option value="Nocturna"{{ old('JORNADA_ESTUDIANTE') == 'Nocturna' ? 'selected' : '' }}>Nocturna</option>
                        </select>
                        </div>

                        <div class="mb-3 mt-3 form-inline">
                            <label for="SECCION" class="form-label mr-2">Sección Académica: </label>
                            <select class="selectize" id="SECCION" name="SECCION" required style="width: 300px;">
                                <option value="" disabled selected>Seleccione la sección académica</option>
                                @foreach ($seccionesArreglo as $seccion)
                                    <option value="{{ $seccion['DESCRIPCION_SECCIONES'] }}"
                                            {{ old('SECCION') == $seccion['DESCRIPCION_SECCIONES'] ? 'selected' : '' }}>
                                        {{ $seccion['DESCRIPCION_SECCIONES'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 mt-3 form-inline">
                            <label for="COD_PADRE_TUTOR" class="form-label mr-2">Encargado: </label>
                            <select class="selectize" id="COD_PADRE_TUTOR" name="COD_PADRE_TUTOR" required style="width: 300px;">
                                <option value="" disabled selected>Seleccione un padre o encargado</option>
                                @foreach ($padresArreglo as $padre)
                                    <option value="{{ $padre['COD_PADRE_TUTOR'] }}"
                                            {{ old('COD_PADRE_TUTOR') == $padre['COD_PADRE_TUTOR'] ? 'selected' : '' }}>
                                        {{ $padre['NOMBRE_PADRE_TUTOR'] }} {{ $padre['APELLIDO_PADRE_TUTOR'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                 
                   <!-- <button type="button" class="btn btn-primary" id="btnAgregarCampo" style="margin-bottom: 20px;">Agregar otro encargado</button>

                   Nuevo bloque oculto inicialmente 
                    <div id="nuevoBloque" style="display: none;">
                        <div class="mb-3 mt-3 form-inline">
                            <label for="COD_PADRE_TUTOR2" class="form-label mr-2">Encargado: </label>
                            <select class="selectize" id="COD_PADRE_TUTOR2" name="COD_PADRE_TUTOR2" required style="width: 300px;">
                                ... Opciones del select ... 
                            </select>
                        </div>
                    </div>-->
                </div> 

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Añadir</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="table-responsive">
<table id="miTabla" class="table table-hover table-light table-striped mt-1" style="border:2px solid lime;">
        <thead>
            <tr>
                <th>#</th>
                <th>Estudiante</th>
                <th>Nivel Académico</th>
                <th>Año Académico</th>
                <th>Sección</th>
                <th>Jornada</th>
                <th>Estado Matricula</th>
                <th>Fecha Matricula </th>
                <th>Encargado </th>
                <th>Opciones Tabla</th>
            </tr>
        </thead>
        <tbody>
            @foreach($matriculaArreglo as $matricula)
            
            @php
                    $persona = null;
                    foreach ($personasArreglo as $p) {
                        if ($p['COD_PERSONA'] === $matricula['COD_PERSONA']) {
                            $persona = $p;
                            break;
                        }
                    }
                @endphp
                @php
                    $nivel_academico = null;
                    foreach ($nivel_academicoArreglo as $n) {
                        if ($n['COD_NIVEL_ACADEMICO'] === $matricula['COD_NIVEL_ACADEMICO']) {
                            $nivel_academico = $n;
                            break;
                        }
                    }
                @endphp

                @php
                    $anio_academico = null;
                    foreach ($anio_academicoArreglo as $a) {
                        if ($a['COD_ANIO_ACADEMICO'] === $matricula['COD_ANIO_ACADEMICO']) {
                            $anio_academico = $a;
                            break;
                        }
                    }
                @endphp
                @php
                    $padres = null;
                    foreach ($padresArreglo as $p) {
                        if ($p['COD_PADRE_TUTOR'] === $matricula['COD_PADRE_TUTOR']) {
                            $padres = $p;
                            break;
                        }
                    }
                @endphp
            <tr>
                <td>{{ $matricula['COD_MATRICULA'] }}</td>
                <td>
                        @if ($persona !== null)
                            {{ $persona['NOMBRE']. ' ' . $persona['APELLIDO'] }}
                        @else
                            Persona no encontrada
                        @endif
                </td>
                 <td>
                        @if ($nivel_academico !== null)
                            {{ $nivel_academico['descripcion']}}
                        @else
                             no encontrado
                        @endif
                 </td>
                 <td>
                        @if ($anio_academico !== null)
                            {{ $anio_academico['descripcion']}}
                        @else
                             no encontrado
                        @endif
                 </td>
                 <td>{{ $matricula['SECCION'] }}</td>
                 <td>{{ $matricula['JORNADA'] }}</td>
                 <td>{{ $matricula['ESTADO_MATRICULA'] }}</td>
                 <td>{{date('d, M Y', strtotime($matricula['FECHA_MATRICULA']))}}</td>
                 <td>
                        @if ($padres !== null)
                            {{ $padres['NOMBRE_PADRE_TUTOR']. ' ' .$padres['APELLIDO_PADRE_TUTOR']}}
                        @else
                             no encontrado
                        @endif
                 </td>
                <td>
                    <button id="botonEditar_1" value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal"
                        data-target="#matricula-edit-{{ $matricula['COD_MATRICULA'] }}">
                        <i class="fas fa-edit" style="font-size: 13px; color: cyan;"></i> Editar
                    </button>
                    <button id="botonEliminar_1" value="editar" title="Eliminar" class="btn btn-outline-danger" type="button" data-toggle="modal"
                            data-target="#matricula-delete-{{$matricula['COD_MATRICULA']}}">
                           <i class='fas fa-trash-alt' style='font-size:13px;color:danger'></i> Eliminar
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


@foreach($matriculaArreglo as $matricula)
<div class="modal fade bd-example-modal-sm" id="matricula-edit-{{ $matricula['COD_MATRICULA'] }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualiza Matricula</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{ url('matricula/actualizar') }}" method="post">
                        @csrf
                        <input type="hidden" class="form-control" name="COD_MATRICULA" value="{{ $matricula['COD_MATRICULA'] }}">
                        <div class="mb-3 mt-3 d-flex align-items-center">
                        <label for="COD_PERSONA"  class="form-label mr-2">Estudiante:</label>
                        <select class="selectize" id="COD_PERSONA" name="COD_PERSONA"  required style="width: 300px;">
                            <option value="" disabled>Seleccione un estudiante</option>
                            @foreach ($personasArreglo as $persona)
                                @if ($persona['TIPO_PERSONA'] === 'Estudiante')
                                    <option value="{{ $persona['COD_PERSONA'] }}"
                                        @if ($persona['COD_PERSONA'] == $matricula['COD_PERSONA']) selected @endif>
                                        {{ $persona['NOMBRE'] }} {{ $persona['APELLIDO'] }} - {{ $persona['IDENTIDAD'] }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3 mt-3 d-flex align-items-center">
                            <label for="COD_NIVEL_ACADEMICO" class="form-label mr-2">Nivel Académico: </label>
                            <select class="selectize" id="COD_NIVEL_ACADEMICO" name="COD_NIVEL_ACADEMICO"  required style="width: 300px;">
                                <option value="" disabled selected>Seleccione el nivel académico</option>
                                @foreach ($nivel_academicoArreglo as $nivel_academico)
                                    <option value="{{ $nivel_academico['COD_NIVEL_ACADEMICO'] }}"
                                        {{ $nivel_academico['COD_NIVEL_ACADEMICO'] == $matricula['COD_NIVEL_ACADEMICO'] ? 'selected' : '' }}>
                                        {{ $nivel_academico['descripcion'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 mt-3 d-flex align-items-center">
                            <label for="COD_ANIO_ACADEMICO" class="form-label mr-2">Año Académico: </label>
                            <select class="selectize" id="COD_ANIO_ACADEMICO" name="COD_ANIO_ACADEMICO"  required style="width: 300px;">
                                <option value="" disabled selected>Seleccione el año académico</option>
                                @foreach ($anio_academicoArreglo as $anio_academico)
                                    <option value="{{ $anio_academico['COD_ANIO_ACADEMICO'] }}"
                                        {{ $anio_academico['COD_ANIO_ACADEMICO'] == $matricula['COD_ANIO_ACADEMICO'] ? 'selected' : '' }}>
                                        {{ $anio_academico['descripcion'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 mt-3 d-flex align-items-center">
                            <label for="ESTADO_MATRICULA" class="form-label mr-2">Estado Matrícula:</label>
                            <select class="selectize" id="ESTADO_MATRICULA" name="ESTADO_MATRICULA"  required style="width: 300px;">
                                <option value="Activo" {{ $matricula['ESTADO_MATRICULA'] == 'Activo' ? 'selected' : '' }}>Activo</option>
                                <option value="Inactivo" {{ $matricula['ESTADO_MATRICULA'] == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                                
                            </select>
                        </div>

                        <div class="mb-3 mt-3 d-flex align-items-center">
                            <label for="JORNADA" class="form-label mr-2">Jornada:</label>
                            <select class="selectize" id="JORNADA" name="JORNADA"  required style="width: 300px;">
                                <option value="Matutina" {{ $matricula['JORNADA'] == 'Matutina' ? 'selected' : '' }}>Matutina</option>
                                <option value="Vespertina" {{ $matricula['JORNADA'] == 'Vespertina' ? 'selected' : '' }}>Vespertina</option>
                                <option value="Nocturna" {{ $matricula['JORNADA'] == 'Nocturna' ? 'selected' : '' }}>Nocturna</option>
                            </select>
                        </div>

                        <div class="mb-3 mt-3 d-flex align-items-center">
                            <label for="SECCION" class="form-label mr-2">Sección Académica: </label>
                            <select class="selectize" id="SECCION" name="SECCION"  required style="width: 300px;">
                                <option value="" disabled selected>Seleccione la sección académica</option>
                                @foreach ($seccionesArreglo as $seccion)
                                    <option value="{{ $seccion['DESCRIPCION_SECCIONES'] }}"
                                        @if ($seccion['DESCRIPCION_SECCIONES'] == $matricula['SECCION']) selected @endif>
                                        {{ $seccion['DESCRIPCION_SECCIONES'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 mt-3 d-flex align-items-center">
                            <label for="COD_PADRE_TUTOR" class="form-label mr-2">Encargado: </label>
                            <select class="selectize" id="COD_PADRE_TUTOR" name="COD_PADRE_TUTOR"  required style="width: 300px;">
                                <option value="" disabled>Seleccione un padre o encargado</option>
                                @foreach ($padresArreglo as $padre)
                                    <option value="{{ $padre['COD_PADRE_TUTOR'] }}"
                                        @if ($padre['COD_PADRE_TUTOR'] == $matricula['COD_PADRE_TUTOR']) selected @endif>
                                        {{ $padre['NOMBRE_PADRE_TUTOR'] }} {{ $padre['APELLIDO_PADRE_TUTOR'] }}
                                    </option>
                                @endforeach 
                            </select>
                        </div>
                        <button id="botonEditar_1" type="submit" class="btn btn-primary">Editar</button>
                        <button id="botonEliminar_1" type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- empieza modal eliminar -->
<div class="modal fade bd-example-modal-sm" id="matricula-delete-{{$matricula['COD_MATRICULA']}}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Atención</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="background-color: #fff; padding: 20px;">
                    <h5 class="modal-title">Desea eliminar este registro</h5>
                  </div>
                  
    <div class="modal-footer">
      <form action="{{ url('matricula/delete') }}" method="post">
                        @csrf
      <input type="hidden" class="form-control" name="COD_MATRICULA" value="{{ $matricula['COD_MATRICULA'] }}">
              <button  class="btn btn-danger">Si</button>
          </form>
        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        
      </div>
    </div>
  </div>
</div>
@endforeach

@stop


@section('footer')
<style>
        body, html {
            height: 100%;
            margin: 0;
        }

        .main-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .content {
            flex: 1;
            padding: 20px;
        }

        .main-footer {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: center;
            display: flex;
            flex-direction: row-reverse; /* Cambia la dirección de los elementos */
            justify-content: space-between;
        }
    </style>
<div>
            Copyright © 2023 UNAH.
        </div>
        <div>
            Todos los derechos reservados.
        </div>
    
@endsection
@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <!-- Agregar estilos para DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.example.com/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.default.min.css">
@stop

@section('js')
    
    <script> console.log('Hi!'); </script>
    <!-- Agregar scripts para DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   <!-- Enlace a selectize-->
   <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js"></script>
    <!-- Reportes -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <!-- Script personalizado para inicializar DataTables -->
    <script>
    $(document).ready(function() {
        $('#miTabla').DataTable({
            "language": {
                "search": "Buscar: ",
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "info": "Mostrando página _PAGE_ de _PAGES_",
                "paginate": {
                    "previous": "Anterior",
                    "next": "Siguiente",
                    "first": "Primero",
                    "last": ""
                }
            },
            "lengthMenu": [5, 10, 30, 50,100,200], // Opciones disponibles en el menú
            "pageLength": 5, // Establece la longitud de página predeterminada en 5
            "order": [[0, 'desc']] // Ordenar por la primera columna de forma descendente
        });
    });
</script>
 
<script>
    // Ejemplo de permisosDisponibles obtenido desde PHP
    var permisosDisponibles = <?php echo json_encode($permisosDisponibles); ?>;
    
    var permisoConsulta = permisosDisponibles[0]['PERMISO_CONSULTAR'];
    var permisoInsercion = permisosDisponibles[0]['PERMISO_INSERCION'];
    var permisoEliminacion = permisosDisponibles[0]['PERMISO_ELIMINACION'];
    var permisoActualizacion = permisosDisponibles[0]['PERMISO_ACTUALIZACION'];


    if (parseInt(permisoInsercion) === 0) {
        // Deshabilitar el botón si permisoInsercion es igual a cero
        var botonNuevo = document.getElementById('botonNuevo');
        botonNuevo.disabled = true;
    }

    if (parseInt(permisoActualizacion) === 0) {
        // Obtener todos los botones de edición
        var botonesEditar = document.querySelectorAll('[id^="botonEditar_"]');
        
        // Iterar sobre los botones y deshabilitarlos
        botonesEditar.forEach(function(boton) {
            boton.disabled = true;
        });
    }  

    if (parseInt(permisoEliminacion) === 0) {
        // Obtener todos los botones de eliminación
        var botonesEliminar = document.querySelectorAll('[id^="botonEliminar_"]');
        
        // Iterar sobre los botones y deshabilitarlos
        botonesEliminar.forEach(function(boton) {
            boton.disabled = true;
        });
    }

    if (parseInt(permisoConsulta) === 0) {
        // Obtener la tabla por su ID
        var tabla = document.getElementById('miTabla');
        
        // Ocultar la tabla
        tabla.style.display = 'none';
    }

    // Acceder a los elementos del array
</script>
    
   <!-- Script personalizado para CAMBIAR MODO -->
   <script>
const modeToggle = document.getElementById('mode-toggle');
const body = document.body;
const table = document.getElementById('miTabla');
const modals = document.querySelectorAll('.modal-content'); // Select all modal content elements

// Check if the selected theme is already stored in localStorage
const storedTheme = localStorage.getItem('theme');
if (storedTheme) {
    body.classList.add(storedTheme); // Apply the stored theme class
    table.classList.toggle('table-dark', storedTheme === 'dark-mode');
    modals.forEach(modal => {
        modal.classList.toggle('dark-mode', storedTheme === 'dark-mode');
    });
}

modeToggle.addEventListener('click', () => {
    body.classList.toggle('dark-mode');
    table.classList.toggle('table-dark');
    
    // Toggle the dark-mode class on modal content elements
    modals.forEach(modal => {
        modal.classList.toggle('dark-mode');
    });

    // Store the selected theme in localStorage
    const theme = body.classList.contains('dark-mode') ? 'dark-mode' : '';
    localStorage.setItem('theme', theme);
});

</script>
<script>
        $(document).ready(function() {
            $('#messageModal').modal('show');
        });
    </script>
    <!-- scripts para selectize-->
     <script>
    $(document).ready(function() {
        $('.selectize').selectize({
            placeholder: 'Seleccione',
            allowClear: true, // Permite borrar la selección
            searchField: ['text', 'IDENTIDAD'], // Habilita la búsqueda por nombre y por identidad
        });
    });
    $(document).ready(function() {
        // Manejar clic en el botón para mostrar/ocultar el nuevo bloque
        $("#btnAgregarCampo").click(function() {
            $("#nuevoBloque").toggle(); // Alternar la visibilidad del bloque
        });
    });
</script>

<!-- scripts para generar reportes excel y pdf-->
<script>
 function generarPDF() {
    const tableData = [];
    const headerData = [];

    // Obtén los datos del encabezado de la tabla (excluyendo la columna "Opciones de la Tabla")
    const tableHeader = document.querySelectorAll('#miTabla thead th');
    tableHeader.forEach(headerCell => {
        if (headerCell.textContent !== 'Opciones de la Tabla') {
            headerData.push({ text: headerCell.textContent, bold: true });
        }
    });

    // Obtén todos los datos de la tabla, incluyendo todas las páginas
    const table = $('#miTabla').DataTable();
    const allData = table.rows().data();
    
    allData.each(function (rowData) {
        const row = [];
        rowData.forEach((cell, index) => {
            // Excluir la última columna y la columna "Opciones de la Tabla"
            if (headerData[index] && index !== rowData.length - 1) {
                row.push(cell);
            }
        });
        tableData.push(row);
    });

    const documentDefinition = {
        pageOrientation: 'landscape', // Establece la orientación de la página a horizontal
        content: [
            {
                text: 'Reporte de Tabla en PDF',
                fontSize: 16,
                bold: true,
                alignment: 'center',
                margin: [0, 0, 0, 10]
            },
            {
                table: {
                    headerRows: 1,
                    widths: Array(headerData.length).fill('auto'),
                    body: [
                        headerData, // Encabezado de la tabla
                        ...tableData // Datos de la tabla
                    ],
                    style: {
                        lineHeight: 1.2 // Ajusta este valor para reducir o aumentar el espacio entre filas
                    }
                }
            }
        ]
    };

    pdfMake.createPdf(documentDefinition).download('reporte.pdf');
}
function generarExcel() {
    const tableData = [];
    const headerData = [];

    // Obtén los datos del encabezado de la tabla (excluyendo la columna "Opciones de la Tabla")
    const tableHeader = document.querySelectorAll('#miTabla thead th');
    tableHeader.forEach(headerCell => {
        if (headerCell.textContent !== 'Opciones de la Tabla') {
            headerData.push(headerCell.textContent);
        }
    });

    // Obtén todos los datos de la tabla, incluyendo todas las páginas
    const table = $('#miTabla').DataTable();
    const allData = table.rows().data();
    
    allData.each(function (rowData) {
        const row = [];
        rowData.forEach((cell, index) => {
            // Excluir la última columna y la columna "Opciones de la Tabla"
            if (index !== rowData.length - 1) {
                row.push(cell);
            }
        });
        tableData.push(row);
    });

    const workbook = XLSX.utils.book_new();
    const worksheetData = [headerData, ...tableData];
    const ws = XLSX.utils.aoa_to_sheet(worksheetData);
    XLSX.utils.book_append_sheet(workbook, ws, 'Sheet1');
    const excelFile = XLSX.write(workbook, { bookType: 'xlsx', type: 'blob' });

    saveAs(excelFile, 'reporte.xlsx'); // Descargar el archivo Excel con un nombre específico
}
function exportToExcel() {
    const tableData = [];
    const headerData = [];

    // Obtén los datos del encabezado de la tabla (excluyendo la columna "Opciones de la Tabla")
    const tableHeader = document.querySelectorAll('#miTabla thead th');
    tableHeader.forEach(headerCell => {
        if (headerCell.textContent !== 'Opciones de la Tabla') {
            headerData.push(headerCell.textContent);
        }
    });

    // Obtén todos los datos de la tabla, incluyendo todas las páginas
    const table = $('#miTabla').DataTable();
    const allData = table.rows().data();
    
    allData.each(function (rowData) {
        const row = [];
        rowData.forEach((cell, index) => {
            // Excluir la última columna y la columna "Opciones de la Tabla"
            if (index !== rowData.length - 1) {
                row.push(cell);
            }
        });
        tableData.push(row);
    });

    const worksheetData = [headerData, ...tableData];

    // Crear un objeto WorkBook y hoja de cálculo
    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.aoa_to_sheet(worksheetData);

    // Agregar la hoja de cálculo al WorkBook
    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

    // Generar el archivo Excel como una matriz binaria
    const excelBinary = XLSX.write(wb, { bookType: 'xlsx', type: 'binary' });

    // Convertir la matriz binaria en un Blob
    const excelBlob = new Blob([s2ab(excelBinary)], {
        type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    });

    // Descargar el archivo usando la biblioteca FileSaver.js
    saveAs(excelBlob, 'reporte.xlsx');
}

// Función para convertir una cadena binaria en una matriz de bytes
function s2ab(s) {
    const buf = new ArrayBuffer(s.length);
    const view = new Uint8Array(buf);
    for (let i = 0; i !== s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
    return view;
}

</script>


@stop