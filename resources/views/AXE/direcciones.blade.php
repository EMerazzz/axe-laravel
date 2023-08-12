@extends('adminlte::page')

@section('title', 'AXE')

@section('content_header')
<blockquote class="custom-blockquote">
    <p class="mb-0">Direcciones registradas en el sistema AXE.</p>
    <footer class="blockquote-footer">Direcciones <cite title="Source Title">Completados</cite></footer>
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
                            <select class="selectize" id="COD_PERSONA" name="COD_PERSONA" required>
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
                            <label for="DEPARTAMENTO" class="form-label">Departamento</label>
                            <input type="text" class="form-control" id="DEPARTAMENTO" name="DEPARTAMENTO" placeholder="Ingrese el departamento">
                            <div id="error-message-departamento" class="error-message" style="color: red; display: none;">Solo se permiten letras y espacios</div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="CIUDAD" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" id="CIUDAD" name="CIUDAD" placeholder="Ingrese la ciudad">
                            <div id="error-message-ciudad" class="error-message" style="color: red; display: none;">Solo se permiten letras y espacios</div>
                            </div>
                        <div class="mb-3 mt-3">
                            <label for="PAIS" class="form-label">País</label>
                            <input type="text" class="form-control" id="PAIS" name="PAIS" placeholder="Ingrese el país">
                            <div id="error-message-pais" class="error-message" style="color: red; display: none;">Solo se permiten letras y espacios</div>
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
                            <input type="text" class="form-control" id="DEPARTAMENTO" name="DEPARTAMENTO" placeholder="Ingrese el departamento" value="{{ $direcciones['DEPARTAMENTO'] }}"
                            title="Solo se permiten letras y espacios"   oninput="this.value = this.value.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g, '')" required>
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="direcciones" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" id="CIUDAD" name="CIUDAD" placeholder="Ingrese la ciudad" value="{{ $direcciones['CIUDAD'] }}"
                            title="Solo se permiten letras y espacios"   oninput="this.value = this.value.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g, '')" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="direcciones" class="form-label">país</label>
                            <input type="text" class="form-control" id="PAIS" name="PAIS" placeholder="Ingrese el país" value="{{ $direcciones['PAIS'] }}"
                            title="Solo se permiten letras y espacios"   oninput="this.value = this.value.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g, '')" required>
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
<!-- Script personalizado para validaciones -->
<script>
function setupValidation(inputId, errorMessageId, pattern) {
    const input = document.getElementById(inputId);
    const errorMessage = document.getElementById(errorMessageId);

    input.addEventListener('input', function() {
        const inputValue = input.value.trim();

        if (!pattern.test(inputValue)) {
            input.value = inputValue.replace(/[^a-zA-Z\s]/g, '');
            errorMessage.style.display = 'block';
        } else {
            errorMessage.style.display = 'none';
        }
    });

    // Llamada inicial para aplicar la validación cuando se cargue la página
    input.dispatchEvent(new Event('input'));
}

// Configuración para el campo de DEPARTAMENTO
setupValidation('DEPARTAMENTO', 'error-message-departamento', /^[a-zA-Z\s]+$/);

// Configuración para el campo de CIUDAD
setupValidation('CIUDAD', 'error-message-ciudad', /^[a-zA-Z\s]+$/);

// Configuración para el campo de PAIS
setupValidation('PAIS', 'error-message-pais', /^[a-zA-Z\s]+$/);
</script>
@stop
