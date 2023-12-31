@extends('adminlte::page')

@section('title', 'Roles')
@section('content_header')
<style>
  .custom-blockquote {
    line-height: 0; /* Reducción de la altura */
    margin-top: -5px; 
    margin-bottom:-5px; /* Reducción del espacio inferior del bloquequote */
  }
</style>
<blockquote class="custom-blockquote">
    <p class="mb-0">Roles registrados en el sistema AXE.</p>
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
<button id="botonNuevo" type="button" class="btn btn-success btn-custom" data-toggle="modal" data-target="#roles">+ Nuevo</button>
<div class="spacer"></div>
<div class="modal fade bd-example-modal-sm" id="roles" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ingresa Rol</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ url('roles/insertar') }}" method="post">
                        @csrf
                        <div class="form-group col-md-12  d-flex"">
                            <div class="form-group col-md-3"> 
                                <label for="DESCRIPCION" class="form-label mr-1">Rol:</label>
                            </div>
                            <div class="form-group col-md-9"> 
                             <input type="text" class="form-control same-width" id="DESCRIPCION" name="DESCRIPCION">
                            </div>
                        </div>

                        <div class="form-group col-md-12 d-flex">
                            <div class="form-group col-md-3">
                              <label for="Estado" class="form-label mr-2">Estado:</label>
                            </div>
                          
                            <div class="form-group col-md-9">
                              <select class="form-control same-width" id="MODIFICADO_POR" name="Estado">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                              </select>
                            </div>
                          </div>
                          
                        
                        <div class="form-group col-md-12  d-flex"">
                         <div class="form-group col-md-3"> 
                             <label for="MODIFICADO_POR" class="form-label mr-1">Modificado:</label>
                        </div>
                        <div class="form-group col-md-9">
                            <input type="text" class="form-control same-width" id="MODIFICADO_POR" name="MODIFICADO_POR" value="{{$UsuarioValue}}" readonly>
                         </div>
                        </div>




                        <button type="submit" class="btn btn-primary">Añadir</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="table-responsive">
<table id="miTabla" class="table table-hover table-light table-striped mt-1" style="border:2px solid lime;">
        
            <thead>
                <tr>
                    <th>#</th> 
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Fecha Creación</th>
                    <th>Fecha Modificación</th>
                    <th>Modificado Por</th> 
                    <th>Opciones Tabla</th>
                </tr>
            </thead>
          
            <tbody>
                @foreach($rolesArreglo as $roles)
                    <tr>
                        <td>{{ $roles['COD_ROL'] }}</td>
                        <td>{{ $roles['DESCRIPCION'] }}</td>
                        <td> 
                        @if($roles['Estado_registro'] == 1)
                        Activo
                    @elseif($roles['Estado_registro'] == 0)
                        Inactivo
                    @endif 
                        </td>
                        <td>{{date('d, M Y', strtotime($roles['FECHA_CREACION']))}}</td>
                        <td>{{date('d, M Y', strtotime($roles['FECHA_MODIFICACION']))}}</td>
                        <!-- <td>{{$UsuarioValue}}</td> -->
                        <td>{{ $roles['MODIFICADO_POR'] }}</td>
                        <td>
                            <button id="botonEditar_1" value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#roles-edit-{{ $roles['COD_ROL'] }}">
                                <i class='fas fa-edit' style='font-size:13px;color:cyan'></i> Editar   
                            </button>
                            <!--< 
                            <button id="botonEliminar_1" value="editar" title="Eliminar" class="btn btn-outline-danger" type="button" data-toggle="modal"
                            data-target="#roles-delete-{{$roles['COD_ROL']}}">
                           <i class='fas fa-trash-alt' style='font-size:13px;color:danger'></i> Eliminar
                           </button>-->
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach($rolesArreglo as $roles)
        <div class="modal fade bd-example-modal-sm" id="roles-edit-{{ $roles['COD_ROL'] }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Actualiza Rol</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ url('roles/actualizar') }}" method="post">
                            @csrf
                            <input type="hidden" class="form-control" name="COD_ROL" value="{{ $roles['COD_ROL'] }}">

                        <div class="form-group col-md-12  d-flex">
                            <div class="form-group col-md-3"> 
                                <label for="DESCRIPCION" class="form-label mr-2">Rol:</label>
                            </div>
                            
                            <div class="form-group col-md-9"> 
                                <input type="text" class="form-control same-width" id="DESCRIPCION" name="DESCRIPCION" value="{{ $roles['DESCRIPCION'] }}">
                            
                            </div>
                        </div>


                         <div class="form-group col-md-12  d-flex">
                            <div class="form-group col-md-3"> 
                                <label for="MODIFICADO_POR" class="form-label mr-2">Modificado:</label>
                            </div>
                            
                            <div class="form-group col-md-9"> 
                                <input type="text" class="form-control same-width" id="MODIFICADO_POR" name="MODIFICADO_POR" value="{{$UsuarioValue}}" readonly>
                            </div>
                        </div>


                        <div class="mb-3 mt-3 d-flex align-items-center">
                            <label for="Estado_registro" class="form-label mr-5 ml-4">Estado:</label>
                           <select class="form-control same-width"   style="width: 325px;" id="Estado_registro" name="Estado">
                           <option value="1" {{ $roles['Estado_registro'] === 1 ? 'selected' : '' }}>Activo</option>
                           <option value="0" {{ $roles['Estado_registro'] === 0 ? 'selected' : '' }}>Inactivo</option>
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


<!-- empieza modal eliminar -->
<div class="modal fade bd-example-modal-sm" id="roles-delete-{{ $roles['COD_ROL'] }}" tabindex="-1">
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
                <form action="{{ url('roles/delete') }}" method="post">
                    @csrf
                    <input type="hidden" class="form-control" name="COD_ROL" value="{{ $roles['COD_ROL'] }}">
                    <button type="submit" class="btn btn-danger">Sí</button>
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
            allowClear: true // Permite borrar la selección
        });
    });
</script>
@stop