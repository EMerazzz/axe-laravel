@extends('adminlte::page')

@section('title', 'Asignatura & Año Academico ')
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
<button type="button" class="btn btn-success btn-custom" data-toggle="modal" data-target="#rel_nivacad_anioacad">+ Nuevo</button>
<div class="spacer"></div>
<div class="modal fade bd-example-modal-sm" id="rel_nivacad_anioacad" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Ingresa</h4>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
           
            
            <div class="modal-footer">
                <div class="d-grid gap-2 col-12 mx-auto">
                    <form action="{{url('rel_nivacad_anioacad/insertar')}}" method="post">

                        @csrf
                       
                        <div class="form-group col-md-12  d-flex"">
                            <div class="form-group col-md-2"> 
                            <label for="COD_NIVEL_ACADEMICO"class="form-label mr-2">Nivel Academico: </label>
                        </div>
                        <div class="form-group col-md-10"> 
                            <select class="selectize" id="COD_NIVEL_ACADEMICO" name="COD_NIVEL_ACADEMICO" required>
                                <option value="" disabled selected>Seleccione el nivel academico</option>
                                @foreach ($nivel_academicoArreglo as $nivel_academico)
                                    <option value="{{ $nivel_academico['COD_NIVEL_ACADEMICO'] }}">{{ $nivel_academico['DESCRIPCION'] }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                        
                    <div class="form-group col-md-12  d-flex"">
                            <div class="form-group col-md-2"> 
                            <label for="COD_ANIO_ACADEMICO"class="form-label mr-2">Año Academico: </label>
                        </div>
                        <div class="form-group col-md-10"> 
                            <select class="selectize" id="COD_ANIO_ACADEMICO" name="COD_ANIO_ACADEMICO" required>
                                <option value="" disabled selected>Seleccione el año academico:</option>
                                @foreach ($anio_academicoArreglo as $anio_academico)
                                    <option value="{{ $anio_academico['COD_ANIO_ACADEMICO'] }}">{{ $anio_academico['descripcion'] }}</option>
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
                    <th>Nivel Academico</th> 
                    <th>Año Academico</th>
                    <th>Estado</th>
                    <th>Opciones Tabla</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rel_nivacad_anioacadArreglo as $rel_nivacad_anioacad)
                @php
                $nivel = null;
                    foreach ($nivel_academicoArreglo as $n) {
                        if ($n['COD_NIVEL_ACADEMICO'] === $rel_nivacad_anioacad['COD_NIVEL_ACADEMICO']) {
                            $nivel = $n;
                            break;
                        }
                    }
                @endphp
                @php
                    $anio = null;
                    foreach ($anio_academicoArreglo as $a) {
                        if ($a['COD_ANIO_ACADEMICO'] === $rel_nivacad_anioacad['COD_ANIO_ACADEMICO']) {
                            $anio = $a;
                            break;
                        }
                    }
                @endphp
                    <tr>
                        <td>{{ $rel_nivacad_anioacad['COD_NIVACAD_ANIOACAD'] }}</td>
                        <td>
                        @if ($nivel !== null)
                            {{ $nivel['DESCRIPCION'] }}
                        @else
                            Nivel no encontrado
                        @endif
                        </td>
                        <td>
                        @if ($anio !== null)
                            {{ $anio['descripcion'] }}
                        @else
                            Año no encontrado
                        @endif
                    </td>
                        <td>
                        @if($rel_nivacad_anioacad['Estado_registro'] == 1)
                        Activo
                    @elseif($rel_nivacad_anioacad['Estado_registro'] == 0)
                        Inactivo
                    @endif 
                        </td>
                        <td>
                            <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#rel_nivacad_anioacad-edit-{{ $rel_nivacad_anioacad['COD_NIVACAD_ANIOACAD'] }}" >
                                <i class='fas fa-edit' style='font-size:13px;color:cyan'></i> Editar
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach($rel_nivacad_anioacadArreglo as $rel_nivacad_anioacad)
        <div class="modal fade bd-example-modal-sm" id="rel_nivacad_anioacad-edit-{{ $rel_nivacad_anioacad['COD_NIVACAD_ANIOACAD'] }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Actualiza Asignatura</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('rel_nivacad_anioacad/actualizar') }}" method="post">
                            @csrf
                            <input type="hidden" class="form-control" name="COD_NIVACAD_ANIOACAD" value="{{ $rel_nivacad_anioacad['COD_NIVACAD_ANIOACAD'] }}">
                            
                            <div class="form-group col-md-12 d-flex"> 
                            <div class="form-group col-md-2"> 
                                     <label for="COD_NIVEL_ACADEMICO" class="form-label form-inline">Nivel Academico :</label>
                             </div>
                             <div class="form-group col-md-10"> 
                            <select class="selectize" id="COD_NIVEL_ACADEMICO" name="COD_NIVEL_ACADEMICO" required>
                                @foreach ($nivel_academicoArreglo as $nivel_academico)
                                    <option value="{{ $nivel_academico['COD_NIVEL_ACADEMICO'] }}" {{ $nivel_academico['COD_NIVEL_ACADEMICO'] == $rel_nivacad_anioacad['COD_NIVEL_ACADEMICO'] ? 'selected' : '' }}>
                                        {{ $nivel_academico['DESCRIPCION'] }} 
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        </div>
                        
                        <div class="form-group col-md-12 d-flex"> 
                            <div class="form-group col-md-2"> 
                                     <label for="COD_ANIO_ACADEMICO" class="form-label form-inline">Año Academico :</label>
                             </div>
                             <div class="form-group col-md-10"> 
                            <select class="selectize" id="COD_ANIO_ACADEMICO" name="COD_ANIO_ACADEMICO" required>
                                @foreach ($anio_academicoArreglo as $anio_academico)
                                    <option value="{{ $anio_academico['COD_ANIO_ACADEMICO'] }}" {{ $anio_academico['COD_ANIO_ACADEMICO'] == $rel_nivacad_anioacad['COD_ANIO_ACADEMICO'] ? 'selected' : '' }}>
                                        {{ $anio_academico['descripcion'] }} 
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        </div>

                            <div class="mb-3 mt-3 d-flex align-items-center">
                            <label for="Estado_registro" class="form-label mr-5">Estado:</label>
                           <select class="form-control same-width" id="Estado_registro" name="Estado">
                           <option value="1" {{ $rel_nivacad_anioacad['Estado_registro'] === 1 ? 'selected' : '' }}>Activo</option>
                           <option value="0" {{ $rel_nivacad_anioacad['Estado_registro'] === 0 ? 'selected' : '' }}>Inactivo</option>
                          </select>
                           </div>
                            <!-- ... otros campos del formulario ... -->
                            <button type="submit" class="btn btn-primary">Editar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
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
