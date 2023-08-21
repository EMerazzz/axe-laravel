@extends('adminlte::page')

@section('title', 'Matriculas')

@section('content_header')
<<blockquote class="custom-blockquote">
    <p class="mb-0">Matriculas registradas en el sistema AXE.</p>
    <footer class="blockquote-footer">Matriculas <cite title="Source Title">Completadas</cite></footer>
</blockquote>

@stop

@section('content')
<div class="d-flex justify-content-end align-items-center">
    <button id="mode-toggle" class="btn btn-info ms-2">
        <i class="fas fa-adjust"></i> Cambiar Modo
    </button>
</div>
<style>
    .same-width {
        width: 100%; /* El combobox ocupará el mismo ancho que el textbox */
    }
</style>

<style>
    .btn-custom {
        margin-top: -70px; /* Ajusta el valor según tus necesidades */
    }
</style>
@if (session('message'))
<div class="modal fade message-modal" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #325d64; color:white;">
                    <h3 class="modal-title" id="messageModalLabel">Mensaje:</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background-color: #c8dbff;">
                    <center><h3 style="color: #333;">{{ session('message.text') }}</h3></center>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="spacer"></div>
<button type="button" class="btn btn-success btn-custom" data-toggle="modal" data-target="#matricula">+Matricular</button>
<div class="spacer"></div>
<div class="modal fade bd-example-modal-sm" id="matricula" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ingresa una nueva matricula</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>   
            <div class="modal-body">
                <p>Ingrese los Datos:</p>
            </div>
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{ url('matricula/insertar') }}" method="post">
                        @csrf
                        <!-- INICIO --->
                        <div class="mb-3 mt-3">
    <label for="COD_PERSONA" class="form-label">Estudiante: </label>
    <select class="selectize" id="COD_PERSONA" name="COD_PERSONA" required>
        <option value="" disabled selected>Seleccione un estudiante</option>
        @foreach ($personasArreglo as $persona)
            @if ($persona['TIPO_PERSONA'] === 'Estudiante')
                <option value="{{ $persona['COD_PERSONA'] }}">{{ $persona['NOMBRE'] }} {{ $persona['APELLIDO'] }}</option>
            @endif
        @endforeach
    </select>
    </div>
                        <!-- FIN --->
                        <div class="mb-3 mt-3">
                            <label for="COD_NIVEL_ACADEMICO" class="form-label">Nivel academico: </label>
                            <select class="selectize" id="COD_NIVEL_ACADEMICO" name="COD_NIVEL_ACADEMICO" required>
                                <option value="" disabled selected>Seleccione el nivel academico</option>
                                @foreach ($nivel_academicoArreglo as $nivel_academico)
                                    <option value="{{ $nivel_academico['COD_NIVEL_ACADEMICO'] }}">{{ $nivel_academico['descripcion'] }}</option>
                                @endforeach
                            </select>
                            </div>

                            <div class="mb-3 mt-3">
                            <label for="COD_ANIO_ACADEMICO" class="form-label">Año academico: </label>
                            <select class="selectize" id="COD_ANIO_ACADEMICO" name="COD_ANIO_ACADEMICO" required>
                                <option value="" disabled selected>Seleccione el año academico</option>
                                @foreach ($anio_academicoArreglo as $anio_academico)
                                    <option value="{{ $anio_academico['COD_ANIO_ACADEMICO'] }}">{{ $anio_academico['descripcion'] }}</option>
                                @endforeach
                            </select>
                            </div>

                            <div class="mb-3">
                            <label for="matricula" class="form-label">Estado Matricula:</label>
                            <select class="selectize" id="ESTADO_MATRICULA" name="ESTADO_MATRICULA">
                            <option value="Activo" {{ old('ESTADO_MATRICULA') == 'Activo' ? 'selected' : '' }}>Activo</option>
                            <option value="Inactivo"{{ old('ESTADO_MATRICULA') == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                            </select>
                            </div>

                            <div class="mb-3">
                        <label for="estudiantes" class="form-label">Jornada:</label>
                        <select class="selectize" id="JORNADA" name="JORNADA">
                            <option value="Matutina" {{ old('JORNADA_ESTUDIANTE') == 'Matutina' ? 'selected' : '' }}>Matutina</option>
                            <option value="Vespertina"{{ old('JORNADA_ESTUDIANTE') == 'Vespertina' ? 'selected' : '' }}>Vespertina</option>
                            <option value="Nocturna"{{ old('JORNADA_ESTUDIANTE') == 'Nocturna' ? 'selected' : '' }}>Nocturna</option>
                        </select>
                        </div>

                            <div class="mb-3 mt-3">
                            <label for="SECCION" class="form-label">Seccion Academica: </label>
                            <select class="selectize" id="SECCION" name="SECCION" required>
                                <option value="" disabled selected>Seleccione la seccion academica</option>
                                @foreach ($seccionesArreglo as $secciones)
                                    <option value="{{ $secciones['DESCRIPCION_SECCIONES'] }}">{{ $secciones['DESCRIPCION_SECCIONES'] }}</option>
                                @endforeach
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
<table id="miTabla" class="table table-hover table-light table-striped mt-1" style="border:2px solid lime;">
        <thead>
            <tr>
                <th>#</th>
                <th>Estudiante</th>
                <th>Nivel Academico</th>
                <th>Año Academico</th>
                <th>Sección</th>
                <th>Jornada</th>
                <th>Estado Matricula</th>
                <th>Fecha Matricula </th>
                <th>Opciones de la Tabla</th>
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
                    <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal"
                        data-target="#matricula-edit-{{ $matricula['COD_MATRICULA'] }}">
                        <i class="fas fa-edit" style="font-size: 13px; color: cyan;"></i> Editar
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
                <h5 class="modal-title">Actualiza la matricula seleccionada</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Ingresa los Nuevos Datos</p>
            </div>
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{ url('matricula/actualizar') }}" method="post">
                        @csrf
                        <input type="hidden" class="form-control" name="COD_MATRICULA" value="{{ $matricula['COD_MATRICULA'] }}">
                        
        

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
            allowClear: true // Permite borrar la selección
        });
    });
</script>
@stop
