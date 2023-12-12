@extends('adminlte::page')

@section('title', 'Docentes & Año Asignaturas ')
@section('content_header')
<style>
  .custom-blockquote {
    line-height: 0; /* Reducción de la altura */
    margin-top: -5px; 
    margin-bottom:-5px; /* Reducción del espacio inferior del bloquequote */
  }
</style>
<blockquote class="custom-blockquote">
    <p class="mb-0">Tabla Relacción en el sistema AXE.</p>
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
<button type="button" class="btn btn-success btn-custom" data-toggle="modal" data-target="#rel_docentes_asig">+ Nuevo</button>
<div class="spacer"></div>
<div class="modal fade bd-example-modal-sm" id="rel_docentes_asig" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ingresa</h4>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
           
            
            <div class="modal-footer">
                <div class="d-grid gap-2 col-12 mx-auto">
                    <form action="{{url('rel_docentes_asig/insertar')}}" method="post">

                        @csrf
                       
                        <div class="mb-3 mt-3 d-flex align-items-center">
                            <div class="form-group mr-2"> 
                            <label for="COD_ASIGNATURA"class="form-label mr-2">Ingrese la Asignatura: </label>
                        </div>
                        <div class="form-group col-md-10"> 
                            <select class="selectize" id="COD_ASIGNATURA" name="COD_ASIGNATURA" required>
                                <option value="" disabled selected>Seleccione la asignatura</option>
                                @foreach ($asignaturasArreglo as $asignaturas)
                                    <option value="{{ $asignaturas['COD_ASIGNATURA'] }}">{{ $asignaturas['NOMBRE_ASIGNATURA'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                        
                    <div class="mb-3 mt-3 d-flex align-items-center">
                            <div class="form-group mr-1"> 
                            <label for="COD_DOCENTE"class="form-label mr-2">Docente: </label>
                        </div>
                        <div class="form-group col-md-10"> 
                            <select class="selectize" id="COD_DOCENTE" name="COD_DOCENTE" required>
                                <option value="" disabled selected>Seleccione el docente:</option>
                                @foreach ($rel_docentes_asigArreglo as $rel_docentes_asig)
                                    <option value="{{ $rel_docentes_asig['COD_DOCENTE'] }}">
                                    {{ $rel_docentes_asig['NOMBRE'] }} {{ $rel_docentes_asig['APELLIDO'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                        
                        
                        <div class="mb-3 mt-3 d-flex align-items-center">
                            <label for="Estado_registro" class="form-label mr-5">Estado:</label>
                           <select class="form-control same-width" id="Estado_registro" name="Estado">
                           <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
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
                    <th>Código</th> 
                    <th>Nombre</th>
                    <th>Asignatura</th> 
                    <th>Estado</th>
                    <th>Opciones Tabla</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rel_docentes_asigArreglo as $rel_docentes_asig)

                @php
                $asig = null;
                    foreach ($asignaturasArreglo as $a) {
                        if ($a['COD_ASIGNATURA'] === $rel_docentes_asig['COD_ASIGNATURA']) {
                            $asig = $a;
                            break;
                        }
                    }
                @endphp

               
                    <tr>
                        <td>{{ $rel_docentes_asig['COD_DOCEN_ASIG'] }}</td>
                        <td>
                            {{ $rel_docentes_asig['NOMBRE'] }} {{ $rel_docentes_asig['APELLIDO'] }}
                      
                        </td>
                        <td>{{ $rel_docentes_asig['ASIGNATURA IMPARTIDA'] }}</td>
                        
                        <td>
                        @if($rel_docentes_asig['Estado_registro'] == 1)
                        Activo
                    @elseif($rel_docentes_asig['Estado_registro'] == 0)
                        Inactivo
                    @endif 
                        </td>
                        <td>
                            <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#rel_docentes_asig-edit-{{ $rel_docentes_asig['COD_DOCEN_ASIG'] }}" >
                                <i class='fas fa-edit' style='font-size:13px;color:cyan'></i> Editar
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach($rel_docentes_asigArreglo as $rel_docentes_asig)
   <div class="modal fade bd-example-modal-sm" id="rel_docentes_asig-edit-{{ $rel_docentes_asig['COD_DOCEN_ASIG'] }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualiza Docente</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: #fff;">
                <form action="{{ url('rel_docentes_asig/actualizar') }}" method="post">
                    @csrf
                    <input type="hidden" class="form-control" name="COD_DOCEN_ASIG" value="{{ $rel_docentes_asig['COD_DOCEN_ASIG'] }}">

                    <div class="mb-3 mt-3 d-flex align-items-center">
    <div class="form-group mr-1"> 
        <label for="COD_DOCENTE" class="form-label mr-2">Docente: </label>
    </div>
    <div class="form-group col-md-10"> 
        <select class="selectize" id="COD_DOCENTE" name="COD_DOCENTE" required>
            <option value="" disabled selected>Seleccione el docente:</option>
            @foreach ($docentesArreglo as $docente)
                <option value="{{ $docente['COD_DOCENTE'] }}" 
                    {{ $docente['COD_DOCENTE'] == $rel_docentes_asig['COD_DOCENTE'] ? 'selected' : '' }}>
                    {{ $rel_docentes_asig['NOMBRE'] }} {{ $rel_docentes_asig['APELLIDO'] }}
                </option>
            @endforeach
        </select>
    </div>
</div>


                        
                    <div class="mb-3 mt-3 d-flex align-items-center">
                        <div class="form-group col-md-2"> 
                            <label for="COD_ASIGNATURA" class="form-label mr-2">Asignatura</label>
                        </div>
                        <div class="form-group col-md-10"> 
                            <select class="selectize" id="COD_ASIGNATURA" name="COD_ASIGNATURA" required>
                                @foreach ($asignaturasArreglo as $asignaturas)
                                    <option value="{{ $asignaturas['COD_ASIGNATURA'] }}" {{ $asignaturas['COD_ASIGNATURA'] == $rel_docentes_asig['COD_ASIGNATURA'] ? 'selected' : '' }}>
                                        {{ $asignaturas['NOMBRE_ASIGNATURA'] }} 
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                 

                    <div class="mb-3 mt-3 d-flex align-items-center">
                        <label for="Estado_registro" class="form-label mr-4 ml-2">Estado:</label>
                        <select class="form-control same-width" id="Estado_registro" name="Estado">
                            <option value="1" {{ $rel_docentes_asig['Estado_registro'] === 1 ? 'selected' : '' }}>Activo</option>
                            <option value="0" {{ $rel_docentes_asig['Estado_registro'] === 0 ? 'selected' : '' }}>Inactivo</option>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Editar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                </form>
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