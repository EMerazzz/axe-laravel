@extends('adminlte::page')

@section('title', 'Nivel Académico')
@section('content_header')

@section('content_header')
<blockquote class="custom-blockquote">
    <p class="mb-0">Niveles académicos registrados en el sistema AXE.</p>
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
              <h4 class="modal-title">Ingresa Nivel Académico</h4>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{url('nivel_academico/insertar')}}" method="post">
                        @csrf
                <!-- INICIO --->
                <div class="mb-3">
                        <label for="nivel_academico" class="form-label">Niveles Académicos:</label>
                        <select class="form-control same-width" id="descripcion" name="descripcion">
                        <option value="Ciclo Comun" selected>Ciclo Común</option>
                        <option value="Bachillerato Informatica"selected>Bachillerato Informática</option>
                        <option value="Bachillerato Finanzas"selected>Bachillerato Finanzas</option>
                        <option value="Bachillerato Humanidades"selected>Bachillerato Humanidades</option>
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
        <th>#</th> 
        <th>Nivel Académico</th> 
        <th>Opciones Tabla</th>
    </thead>
    <tbody>
        @foreach($nivel_academicoArreglo as $nivel_academico)
        <tr>
            <td>{{$nivel_academico['COD_NIVEL_ACADEMICO']}}</td>
            <td>{{$nivel_academico['descripcion']}}</td>
            <td>
                <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#nivel_academico-edit-{{$nivel_academico['COD_NIVEL_ACADEMICO']}}">
                    <i class='fas fa-edit' style='font-size:13px;color:cyan'></i> Editar
                </button>
                <div class="modal fade bd-example-modal-sm" id="nivel_academico-edit-{{$nivel_academico['COD_NIVEL_ACADEMICO']}}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Actualiza Academico</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-footer">
                                <div class="d-grid gap-2 col-6 mx-auto">
                                    <form action="{{url('nivel_academico/actualizar')}}" method="post">
                                        @csrf
                                        <input type="hidden" class="form-control" name="COD_NIVEL_ACADEMICO" value="{{$nivel_academico['COD_NIVEL_ACADEMICO']}}">
                                       
                                        <div class="mb-3">
                                        <label for="nivel_academico" class="form-label">Niveles Académicos:</label>
                                        <select class="form-control same-width" id="descripcion" name="descripcion">
                                        <option value="Ciclo Común" {{ $nivel_academico['descripcion'] === 'Ciclo Común' ? 'selected' : '' }}>Ciclo Común</option>
                                        <option value="Bachillerato Informática" {{ $nivel_academico['descripcion'] === 'Bachillerato Informática' ? 'selected' : '' }}>Bachillerato Informática</option>
                                        <option value="Bachillerato Finanzas" {{ $nivel_academico['descripcion'] === 'Bachillerato Finanzas' ? 'selected' : '' }}>Bachillerato Finanzas</option>
                                        <option value="Bachillerato Humanidades" {{ $nivel_academico['descripcion'] === 'Bachillerato Humanidades' ? 'selected' : '' }}>Bachillerato Humanidades</option>
                                        </select>
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
    //setupValidation('NOMBRE', 'error-message-nombre', /[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g);
    // Configuración para el campo de APELLIDO
    //setupValidation('APELLIDO', 'error-message-apellido', /[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g);
    // Configuración para el campo de IDENTIDAD
    //setupValidation('IDENTIDAD', 'error-message-identidad', /[^0-9]/g);
    
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
