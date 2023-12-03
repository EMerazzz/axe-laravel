@extends('adminlte::page')

@section('title', 'Usuarios')
@section('content_header')
<style>
  .custom-blockquote {
    line-height: 0; /* Reducción de la altura */
    margin-top: -5px; 
    margin-bottom:-5px; /* Reducción del espacio inferior del bloquequote */
  }
</style>
<<blockquote class="custom-blockquote">
    <p class="mb-0">Usuarios registrados en el sistema AXE.</p>
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

<div class="spacer"></div>
<!-- Este es un comentario -->


<button type="button" class="btn btn-success btn-custom" data-toggle="modal" data-target="#usuarios" id="botonNuevo">+ Nuevo</button>

<div class="spacer"></div>
<div class="modal fade bd-example-modal-sm" id="usuarios" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ingresa Usuario</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{url('usuarios/insertar')}}" method="post">
                        @csrf
                 <!-- INICIO --->
                 <div class="mb-3 mt-3">
                 <label for="usuarios" class="form-label">Usuario:</label>
                 <input type="text" class="form-control" id="USUARIO" name="USUARIO" placeholder="Ingrese el usuario" pattern="^[A-Za-záéíóúÁÉÍÓÚñÑ0-9 ]+$" title="Solo se permiten letras, números y espacios" required>
                 </div>

                 <div class="mb-3 mt-3">
                 <label for="usuarios" class="form-label">Contraseña:</label>
                 <input type="password" class="form-control" id="CONTRASENA" name="CONTRASENA" placeholder="Ingrese la contraseña" pattern="^[A-Za-záéíóúÁÉÍÓÚñÑ0-9!@#$%^&*()-_+=<>?]+$" title="Se permiten letras, números y caracteres especiales: !@#$%^&*()-_+=<>?" required>
                 </div>

                 <div class="mb-3 mt-3">
                    <label for="COD_PERSONA" class="form-label">Personal: </label>
                    <select class="selectize" id="COD_PERSONA" name="COD_PERSONA" required>
                        <option value="" disabled selected>Seleccione una persona</option>
                        @foreach ($personasArreglo as $persona)
                            @php
                                $usuariosColeccion = collect($usuariosArreglo);
                            @endphp

                            @if ($persona['TIPO_PERSONA'] === 'Personal Administrativo' && !$usuariosColeccion->contains('COD_PERSONA', $persona['COD_PERSONA']))
                                <option value="{{ $persona['COD_PERSONA'] }}">{{ $persona['NOMBRE'] }} {{ $persona['APELLIDO'] }} - {{ $persona['IDENTIDAD'] }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 mt-3">
                <label for="COD_ROL" class="form-label">Rol: </label>
                    <select class="selectize" id="COD_ROL" name="COD_ROL" required>
                    <option value="" disabled selected>Seleccione el Rol</option>
                    @foreach ($rolesArreglo as $roles)
                    <option value="{{ $roles['COD_ROL'] }}">{{ $roles['DESCRIPCION'] }}</option>
                    @endforeach
                    </select>
                </div>
                <div class="mb-3">
                        <label for="COD_ESTADO_USUARIO" class="form-label">Estado usuario:</label>
                        <select class="form-control same-width" id="COD_ESTADO_USUARIO" name="COD_ESTADO_USUARIO">
                        <option value="1" selected>Activo</option>
                        <option value="2">Inactivo</option>
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
                <th>Nombre completo</th>
                <th>Usuario</th>
                <th>Primer Ingreso</th>
                <th>Número Intentos</th>
                <th>Estado de usuario</th>
                <th>Modificado Por</th>

               
                <!-- <th>Estado</th> -->
                <th>Opciones Tabla</th>
            </tr>
        </thead>
        <tbody>
            @foreach($usuariosArreglo as $usuarios)
            @php
                    $persona = null;
                    foreach ($personasArreglo as $p) {
                        if ($p['COD_PERSONA'] === $usuarios['COD_PERSONA']) {
                            $persona = $p;
                            break;
                        }
                    }    
            @endphp

    

            <tr>
                <td>{{ $usuarios['COD_USUARIO'] }}</td>
                <td>
                        @if ($persona !== null)
                            {{ $persona['NOMBRE'] }} {{ $persona['APELLIDO'] }}
                        @else
                            Persona no encontrada
                        @endif
                </td>
                <td>{{ $usuarios['USUARIO'] }}</td>
                <td>
                    @if($usuarios['PRIMER_INGRESO'] == 1)
                        Realizado
                    @elseif($usuarios['PRIMER_INGRESO'] == 0)
                        No Realizado
                    @endif
                 </td>
                <td>{{ $usuarios['N_INTENTOS'] }}</td>
                <td>
                    @if($usuarios['COD_ESTADO_USUARIO'] == 1)
                        Activo
                    @elseif($usuarios['COD_ESTADO_USUARIO'] == 0)
                        Inactivo
                    @endif
                 </td>
                <td>{{ $usuarios['MODIFICADO_POR'] }}</td>
                    
                <td>
                    <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal"
                    data-target="#usuarios-edit-{{ $usuarios['COD_USUARIO'] }}" id="botonEditar_{{ $usuarios['COD_USUARIO'] }}">
                    <i class="fas fa-edit" style="font-size: 13px; color: cyan;"></i> Editar
                    </button>
                    
                   <!-- boton eliminar-->
                   <button value="Eliminar" title="Eliminar" class="btn btn-outline-danger" type="button" data-toggle="modal"
                   data-target="#usuarios-delete-{{ $usuarios['COD_USUARIO'] }}" id="botonEliminar_{{ $usuarios['COD_USUARIO'] }}">
                   <i class="fas fa-trash-alt" style="font-size: 13px; color: danger;"></i> Eliminar
               </button>
                     <!-- boton eliminar-->
                </td>


               
              

             
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@foreach($usuariosArreglo as $usuarios)
<!-- empieza modal eliminar -->
<div class="modal fade bd-example-modal-sm" id="usuarios-delete-{{$usuarios['COD_USUARIO']}}" tabindex="-1">
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
      <form action="{{ url('usuarios/delete') }}" method="post">
                        @csrf
      <input type="hidden" class="form-control" name="COD_USUARIO" value="{{ $usuarios['COD_USUARIO'] }}">
              <button  class="btn btn-danger">Si</button>
          </form>
        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        
      </div>
    </div>
  </div>
</div>

<!-- termina eliminar -->
<!-- empieza modal editar -->
<div class="modal fade bd-example-modal-sm" id="usuarios-edit-{{ $usuarios['COD_USUARIO'] }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualiza Usuario</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{ url('usuarios/actualizar') }}" method="post">
                        @csrf
                        <input type="hidden" class="form-control" name="COD_USUARIO" value="{{ $usuarios['COD_USUARIO'] }}">

                        <div class="mb-3 mt-3">
                        <label for="usuarios" class="form-label">Usuario:</label>
                        <input type="text" class="form-control" id="USUARIO" name="USUARIO" placeholder="Ingrese el usuario" value="{{ $usuarios['USUARIO'] }}"
                        pattern="^[A-Za-z0-9]+$" title="Solo se permiten letras y números">
                        </div>
                        
                        <div class="mb-3 mt-3">
                        <label for="contrasena" class="form-label">Contraseña:</label>
                        <input type="password" class="form-control" id="CONTRASENA" name="CONTRASENA" placeholder="Ingrese la contraseña"
                         pattern="^[A-Za-z0-9!@#$%^&*()-_+=<>?]+$" title="Se permiten letras, números y caracteres especiales: !@#$%^&*()-_+=<>?" value="{{ $usuarios['CONTRASENA'] }}">
                        </div>

                        
                        <button type="submit" class="btn btn-primary">Editar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- termina editar -->
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
            }
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
            searchField: ['text', 'IDENTIDAD'], // Habilita la búsqueda por nombre, apellido e ID
        });
    });
    function personaEstaSeleccionada(personas, usuarios) {
        // Implementa la lógica aquí para verificar si la persona ya está seleccionada en $usuarios
        // Por ejemplo, podrías verificar si el código de la persona está presente en $usuarios.
        return usuarios.some(usuario => usuarios['COD_PERSONA'] === personas['COD_PERSONA']);
    }
   
</script>
<script></script>

   
@stop