@extends('adminlte::page')

@section('title', 'Secciones')
@section('content_header')

@section('content_header')
<style>
  .custom-blockquote {
    line-height: 0; /* Reducción de la altura */
    margin-top: -5px; 
    margin-bottom:-5px; /* Reducción del espacio inferior del bloquequote */
  }
</style>
<blockquote class="custom-blockquote">
    <p class="mb-0">Secciones registrados en el sistema AXE.</p>
</blockquote>

@stop


@section('content')
<!-- Cambiar Modo
<div class="d-flex justify-content-end align-items-center">
    <button id="mode-toggle" class="btn btn-info ms-2">
        <i class="fas fa-adjust"></i> Cambiar Modo
    </button>
</div>--->
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
<button type="button" class="btn btn-success btn-custom" data-toggle="modal" data-target="#personas">+ Nuevo</button>
<div class="spacer"></div>
<div class="modal fade bd-example-modal-sm" id="personas" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ingresa Sección</h4>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{url('secciones/insertar')}}" method="post">
                        @csrf
                <!-- INICIO --->
                <div class="mb-3 mt-3 d-flex align-items-center">
                    <label for="DESCRIPCION_SECCIONES" class="form-label mr-2">Sección</label>
                    <input type="text" class="form-control same-width" id="DESCRIPCION_SECCIONES" name="DESCRIPCION_SECCIONES" placeholder="Ingrese la sección" required maxlength="200" pattern="^[A-Za-z\s]+$">
                    <small id="errorMessage" style="color: red; display: none;">Solo se permiten letras.</small>
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
        <th>Sección Académica</th> 
        <th>Opciones Tabla</th>
    </thead>
    <tbody>
        @foreach($seccionesArreglo as $secciones)
        <tr>
            <td>{{$secciones['COD_SECCIONES']}}</td>
            <td>{{$secciones['DESCRIPCION_SECCIONES']}}</td>
            <td>
                <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#secciones-edit-{{$secciones['COD_SECCIONES']}}">
                    <i class='fas fa-edit' style='font-size:13px;color:cyan'></i> Editar
                </button>

                <button value="editar" title="Eliminar" class="btn btn-outline-danger" type="button" data-toggle="modal"
                    data-target="#secciones-delete-{{$secciones['COD_SECCIONES']}}">
                    <i class='fas fa-trash-alt' style='font-size:13px;color:danger'></i> Eliminar
                </button>
                <div class="modal fade bd-example-modal-sm" id="secciones-edit-{{$secciones['COD_SECCIONES']}}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Actualiza Sección</h5>
                                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                            </div>
                            <div class="modal-footer">
                                <div class="d-grid gap-2 col-6 mx-auto">
                                    <form action="{{url('secciones/actualizar')}}" method="post">
                                        @csrf
                                        <input type="hidden" class="form-control same-width" name="COD_SECCIONES" value="{{$secciones['COD_SECCIONES']}}">
                                       
                                        <div class="mb-3 mt-3 d-flex align-items-center">
                                            <label for="DESCRIPCION_SECCIONES" class="form-label mr-2">Sección </label>
                                            <input type="text" class="form-control same-width" id="DESCRIPCION_SECCIONES" name="DESCRIPCION_SECCIONES" placeholder="Ingrese la sección" required maxlength="200" pattern="^[A-Za-z\s]+$" 
                                            value="{{$secciones['DESCRIPCION_SECCIONES']}}">
                                        </div>

                                        <!-- ... otros campos del formulario ... -->
                                        <button type="submit" class="btn btn-primary">Editar</button>
                                       
                                        <button type="button" class="btn btn-danger" data-dismiss="modal">cancelar</button>
                                        </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- empieza modal eliminar -->
<div class="modal fade bd-example-modal-sm" id="secciones-delete-{{$secciones['COD_SECCIONES']}}" tabindex="-1">
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
      <form action="{{ url('secciones/delete') }}" method="post">
                        @csrf
      <input type="hidden" class="form-control" name="COD_SECCIONES" value="{{ $secciones['COD_SECCIONES'] }}">
              <button  class="btn btn-danger">Si</button>
          </form>
        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        
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
    document.querySelector('form').addEventListener('submit', function(event) {
        var inputField = document.getElementById('DESCRIPCION_SECCIONES');
        var errorMessage = document.getElementById('errorMessage');
        var regex = /^[A-Za-z\s]+$/;
        if (!regex.test(inputField.value)) {
            errorMessage.style.display = 'block';
            event.preventDefault();
        } else {
            errorMessage.style.display = 'none';
        }
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