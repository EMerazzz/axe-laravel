@extends('adminlte::page')

@section('title', 'AXE')
@section('content_header')

<<blockquote class="custom-blockquote">
    <p class="mb-0">Estudiantes registrados en el sistema AXE.</p>
    <footer class="blockquote-footer">Estudiantes <cite title="Source Title">Completados</cite></footer>
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
<button type="button" class="btn btn-success btn-custom" data-toggle="modal" data-target="#estudiantes">+ Nuevo</button>
<div class="spacer"></div>
<div class="modal fade bd-example-modal-sm" id="estudiantes" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ingresa un nuevo estudiante</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Ingrese los Datos:</p>
            </div>
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{url('estudiantes/insertar')}}" method="post">
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
    <div class="mb-3 mt-3">
    <label for="COD_PADRE_TUTOR" class="form-label">Padre o tutor: </label>
    <select class="selectize" id="COD_PADRE_TUTOR" name="COD_PADRE_TUTOR" required>
        <option value="" disabled selected>Seleccione un padre o tutor</option>
        @foreach ($padresArreglo as $padres)
            <option value="{{ $padres['COD_PADRE_TUTOR'] }}">{{ $padres['NOMBRE_PADRE_TUTOR'] }} {{ $padres['APELLIDO_PADRE_TUTOR'] }}</option>
        @endforeach
    </select>
</div>

                        <div class="mb-3 mt-3">
                            <label for="estudiantes" class="form-label">Nivel año académico:</label>
                            <input type="text" class="form-control" id="COD_NIVACAD_ANIOACAD" name="COD_NIVACAD_ANIOACAD" placeholder="Ingrese el nivel año academico"pattern="^[A-Za-záéíóúÁÉÍÓÚñÑ ]+$" title="Solo se permiten letras y espacios" required>
                        </div>
                        <div class="mb-3">
                        <label for="estudiantes" class="form-label">Jornada:</label>
                        <select class="selectize" id="JORNADA_ESTUDIANTE" name="JORNADA_ESTUDIANTE">
                            <option value="Matutina" selected>Matutina</option>
                            <option value="Vespertina"selected>Vespertina</option>
                            <option value="Nocturna"selected>Nocturna</option>
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
                <th>Nivel año academico</th>
                <th>Nombres estudiantes</th>
                <th>Apellidos estudiante</th>
                <th>Padre o tutor</th>
                <th>Jornada</th>
                <th>Opciones de la Tabla</th>
            </tr>
        </thead>
        <tbody>
            @foreach($estudiantesArreglo as $estudiantes)
            @php
                    $persona = null;
                    foreach ($personasArreglo as $p) {
                        if ($p['COD_PERSONA'] === $estudiantes['COD_PERSONA']) {
                            $persona = $p;
                            break;
                        }
                    }
                @endphp

                @php
                    $padres = null;
                    foreach ($padresArreglo as $e) {
                        if ($e['COD_PADRE_TUTOR'] === $estudiantes['COD_PADRE_TUTOR']) {
                            $padres = $e;
                            break;
                        }
                    }
                @endphp
            <tr>
                <td>{{ $estudiantes['COD_ESTUDIANTE'] }}</td>
                <td>{{ $estudiantes['COD_NIVACAD_ANIOACAD'] }}</td>
                <td>
                        @if ($persona !== null)
                            {{ $persona['NOMBRE'] }}
                        @else
                            Persona no encontrada
                        @endif
                </td>

                <td>
                        @if ($persona !== null)
                            {{ $persona['APELLIDO'] }}
                        @else
                            Persona no encontrada
                        @endif
                </td>
                <td>
                        @if ($padres !== null)
                            {{ $padres['NOMBRE_PADRE_TUTOR'] . ' ' . $padres['APELLIDO_PADRE_TUTOR'] }}
                        @else
                            padre no encontrada
                        @endif
                </td>
                    <td>{{ $estudiantes['JORNADA_ESTUDIANTE'] }}</td>
                <td>
                    <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal"
                        data-target="#estudiantes-edit-{{ $estudiantes['COD_ESTUDIANTE'] }}">
                        <i class="fas fa-edit" style="font-size: 13px; color: cyan;"></i> Editar
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@foreach($estudiantesArreglo as $estudiantes)
<div class="modal fade bd-example-modal-sm" id="estudiantes-edit-{{ $estudiantes['COD_ESTUDIANTE'] }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualiza el estudiante</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Ingresa los Nuevos Datos</p>
            </div>
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{ url('estudiantes/actualizar') }}" method="post">
                        @csrf
                        <input type="hidden" class="form-control" name="COD_ESTUDIANTE" value="{{ $estudiantes['COD_ESTUDIANTE'] }}">

                        <div class="mb-3 mt-3">
                            <label for="estudiantes" class="form-label">nivel año académico:</label>
                            <input type="text" class="form-control" id="COD_NIVACAD_ANIOACAD" name="COD_NIVACAD_ANIOACAD" placeholder="Ingrese la ocupación" value="{{ $estudiantes['COD_NIVACAD_ANIOACAD'] }}">
                        </div>
                        <div class="mb-3">
                        <label for="estudiantes" class="form-label">Jornada:</label>
                        <select class="form-control same-width" id="JORNADA_ESTUDIANTE" name="JORNADA_ESTUDIANTE">
                            <option value="Matutina" {{ $estudiantes['JORNADA_ESTUDIANTE'] === 'Matutina' ? 'selected' : '' }}>Matutina</option>
                            <option value="Vespertina" {{ $estudiantes['JORNADA_ESTUDIANTE'] === 'Vespertina' ? 'selected' : '' }}>Vespertina</option>
                            <option value="Nocturna" {{ $estudiantes['JORNADA_ESTUDIANTE'] === 'Nocturna' ? 'selected' : '' }}>Nocturna</option>

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