@extends('adminlte::page')

@section('title', 'AXE')
@section('content_header')

@section('content_header')
<blockquote class="custom-blockquote">
    <p class="mb-0">Personas registrados en el sistema AXE.</p>
    <footer class="blockquote-footer">Personas <cite title="Source Title">Completados</cite></footer>
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
<button type="button" class="btn btn-success btn-custom" data-toggle="modal" data-target="#personas">+ Nuevo</button>
<div class="spacer"></div>
<div class="modal fade bd-example-modal-sm" id="personas" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ingresa una Nueva Persona</h4>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <h5><p>Ingrese los Datos:</p></h5>
            </div>
            
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{url('personas/insertar')}}" method="post">
                        @csrf
                <!-- INICIO --->
                
                <div class="mb-3 mt-3">
    <label for="NOMBRE" class="form-label">Nombres de la persona:</label>
    <input type="text" class="form-control same-width" id="NOMBRE" name="NOMBRE" placeholder="Ingrese los nombres de la persona" inputmode="text" required value="{{ old('NOMBRE') }}">
    <div id="error-message-nombre" class="error-message" style="color: red; display: none;">Solo se permiten letras y espacios</div>
</div>

<div class="mb-3 mt-3">
    <label for="APELLIDO" class="form-label">Apellidos de la persona:</label>
    <input type="text" class="form-control same-width" id="APELLIDO" name="APELLIDOS" placeholder="Ingrese los apellidos de la persona" inputmode="text" required value="{{ old('APELLIDOS') }}">
    <div id="error-message-apellido" style="color: red; display: none;">Solo se permiten letras y espacios</div>
</div>

<div class="mb-3 mt-3">
    <label for="IDENTIDAD" class="form-label">Numeros de identidad:</label>
    <input type="text" class="form-control same-width" id="IDENTIDAD" name="IDENTIDAD" placeholder="Ingrese numero de identidad de la persona" required>
    <div id="error-message-identidad" style="color: red; display: none;">Solo se permiten números</div>
</div>


<div class="mb-3">
    <label for="personas" class="form-label">Género:</label>
    <select class="form-control same-width" id="GENERO" name="GENERO">
        <option value="M" {{ old('GENERO') == 'M' ? 'selected' : '' }}>Masculino</option>
        <option value="F" {{ old('GENERO') == 'F' ? 'selected' : '' }}>Femenino</option>
    </select>
</div>

<div class="mb-3">
  <label for="personas" class="form-label">Tipo persona:</label>
  <select class="form-control same-width" id="TIPO_PERSONA" name="TIPO_PERSONA">
    <option value="Estudiante" {{ old('TIPO_PERSONA') == 'Estudiante' ? 'selected' : '' }}>Estudiante</option>
    <option value="Docente" {{ old('TIPO_PERSONA') == 'Docente' ? 'selected' : '' }}>Docente</option>
    <option value="Padre o tutor" {{ old('TIPO_PERSONA') == 'Padre o tutor' ? 'selected' : '' }}>Padre o tutor</option>
  </select>
</div>


<div class="mb-3">
  <label for="personas" class="form-label">Fecha de nacimiento:</label>
  @php
    $fechaNacimiento = old('FECHA_NACIMIENTO');
    if ($fechaNacimiento) {
        $fechaNacimiento = date('Y-m-d', strtotime($fechaNacimiento));
    }
  @endphp
  <input type="date" class="form-control same-width" id="FECHA_NACIMIENTO" name="FECHA_NACIMIENTO" value="{{ $fechaNacimiento }}">
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
        <th>#</th> 
        <th>Nombres</th> 
        <th>Apellidos</th>
        <th>Número de identidad</th>
        <th>Genero</th>
        <th>Tipo de persona</th>
        <th>Fecha nacimiento</th>
        <th>Edad</th>
        <th>Fecha registro</th>
        <th>Opciones de la Tabla</th>
    </thead>
    <tbody>
        @foreach($personasArreglo as $personas)
        <tr>
            <td>{{$personas['COD_PERSONA']}}</td>
            <td>{{$personas['NOMBRE']}}</td>
            <td>{{$personas['APELLIDO']}}</td>
            <td>{{$personas['IDENTIDAD']}}</td>
            <td>{{$personas['GENERO']}}</td>
            <td>{{$personas['TIPO_PERSONA']}}</td>
            <td>{{date('d, M Y', strtotime($personas['FECHA_NACIMIENTO']))}}</td>
            <td>{{date_diff(date_create($personas['FECHA_NACIMIENTO']), date_create('today'))->y}}</td>
            <td>{{date('d, M Y', strtotime($personas['FECHA_REGISTRO']))}}</td>
            
            <td>
                <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#personas-edit-{{$personas['COD_PERSONA']}}">
                    <i class='fas fa-edit' style='font-size:13px;color:cyan'></i> Editar
                </button>
                <div class="modal fade bd-example-modal-sm" id="personas-edit-{{$personas['COD_PERSONA']}}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Actualiza la persona seleccionada</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Ingresa los Nuevos Datos</p>
                            </div>
                            <div class="modal-footer">
                                <div class="d-grid gap-2 col-6 mx-auto">
                                    <form action="{{url('personas/actualizar')}}" method="post">
                                        @csrf
                                        <input type="hidden" class="form-control" name="COD_PERSONA" value="{{$personas['COD_PERSONA']}}">
                                       
    <div class="mb-3 mt-3">
        <label for="NOMBRE" class="form-label">Nombres de la persona:</label>
        <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" placeholder="Ingrese los nombres de la persona" value="{{$personas['NOMBRE']}}" 
        title="Solo se permiten letras y espacios" oninput="this.value = this.value.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g, '')" required>
    </div>
                
<div class="mb-3 mt-3">
    <label for="APELLIDO" class="form-label">Apellidos de la persona:</label>
    <input type="text" class="form-control" id="APELLIDO" name="APELLIDO" placeholder="Ingrese los apellidos de la persona" value="{{$personas['APELLIDO']}}" 
    title="Solo se permiten letras y espacios"   oninput="this.value = this.value.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g, '')" required>
</div>
                
<div class="mb-3">
    <label for="IDENTIDAD" class="form-label">Números de identidad:</label>
    <input type="text" class="form-control" id="IDENTIDAD" name="IDENTIDAD" placeholder="Ingrese número de identidad de la persona" value="{{$personas['IDENTIDAD']}}"
    title="Solo se permiten números"  oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
</div>

<div class="mb-3">
  <label for="personas" class="form-label">Tipo de persona:</label>
  <select class="form-control same-width" id="TIPO_PERSONA" name="TIPO_PERSONA">
    <option value="Estudiante" {{ $personas['TIPO_PERSONA'] === 'Estudiante' ? 'selected' : '' }}>Estudiante</option>
    <option value="Docente" {{ $personas['TIPO_PERSONA'] === 'Docente' ? 'selected' : '' }}>Docente</option>
    <option value="Padre o tutor" {{ $personas['TIPO_PERSONA'] === 'Padre o tutor' ? 'selected' : '' }}>Padre o tutor</option>

  </select>
</div>

<div class="mb-3">
  <label for="personas" class="form-label">Género:</label>
  <select class="form-control same-width" id="GENERO" name="GENERO">
    <option value="M" {{ $personas['TIPO_PERSONA'] === 'M' ? 'selected' : '' }}>Masculino</option>
    <option value="F" {{ $personas['TIPO_PERSONA'] === 'F' ? 'selected' : '' }}>Femenino</option>
  </select>
</div>
<div class="mb-3">
  <label for="personas" class="form-label">Fecha de nacimiento:</label>
  <!-- Formatear la fecha de nacimiento con date() y strtotime() -->
  <?php $fecha_nacimiento_formateada = date('Y-m-d', strtotime($personas['FECHA_NACIMIENTO'])); ?>
  <input type="date" class="form-control" id="FECHA_NACIMIENTO" name="FECHA_NACIMIENTO" value="{{ $fecha_nacimiento_formateada }}">
</div>

                                        <!-- ... otros campos del formulario ... -->
                                        <button type="submit" class="btn btn-primary">Editar</button>
                                       
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">cancelar</button>
          </form>
          </div><!-- DIV PARA CENTRAR FORMULARIO--->
       
      </div>
    </div>
  </div>
</div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <!-- Agregar estilos para DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.example.com/css/styles.css">
@stop

@section('js')
    
    <script> console.log('Hi!'); </script>
    <!-- Agregar scripts para DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
 
 <!-- scripts para validaciones-->
 <script>
    function setupValidation(inputId, errorMessageId, pattern) {
        const input = document.getElementById(inputId);
        const errorMessage = document.getElementById(errorMessageId);

        input.addEventListener('input', function() {
            const inputValue = input.value.trim();
            const validInput = inputValue.replace(pattern, '');

            if (inputValue !== validInput) {
                input.value = validInput;
                errorMessage.style.display = 'block';
            } else {
                errorMessage.style.display = 'none';
            }
        });

        // Llamada inicial para aplicar la validación cuando se cargue la página
        input.dispatchEvent(new Event('input'));
    }

    // Configuración para el campo de NOMBRE
    setupValidation('NOMBRE', 'error-message-nombre', /[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g);
    // Configuración para el campo de APELLIDO
    setupValidation('APELLIDO', 'error-message-apellido', /[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g);
    // Configuración para el campo de IDENTIDAD
    setupValidation('IDENTIDAD', 'error-message-identidad', /[^0-9]/g);
    
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

@stop