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
<button type="button" class="btn btn-success btn-custom" data-toggle="modal" data-target="#usuarios">+ Nuevo</button>
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
                 <label for="primerIngreso" class="form-label">Primer Ingreso:</label>
                 <input type="checkbox" class="form-check-input" id="PRIMER_INGRESO" name="PRIMER_INGRESO" value="1">
                 </div>
                 
                 <div class="mb-3 mt-3">
                <label for="MODIFICADO_POR" class="form-label">Modificado:</label>
                <input type="text" class="form-control same-width" id="MODIFICADO_POR" name="MODIFICADO_POR" value="{{$UsuarioValue}}" readonly>
                </div>
                 
                 <div class="mb-3 mt-3">
                <label for="COD_PERSONA" class="form-label">Personal: </label>
                <select class="selectize" id="COD_PERSONA" name="COD_PERSONA" required>
                <option value="" disabled selected>Seleccione una persona</option>
                @foreach ($personasArreglo as $persona)
                @if ($persona['TIPO_PERSONA'] === 'Personal Administrativo')
                <option value="{{ $persona['COD_PERSONA'] }}">{{ $persona['NOMBRE'] }} {{ $persona['APELLIDO'] }}</option>
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
                <th>Usuario</th>
                <th>Primer Ingreso</th>
                <th>Número Intentos</th>
                <th>Modificado Por</th>
                <th>Nombre</th>
                <th>Apellido</th>
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
                <td>{{ $usuarios['USUARIO'] }}</td>
                <td>{{ $usuarios['PRIMER_INGRESO'] }}</td>
                <td>{{ $usuarios['N_INTENTOS'] }}</td>
                <td>{{ $usuarios['MODIFICADO_POR'] }}</td>
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
                    <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal"
                        data-target="#usuarios-edit-{{ $usuarios['COD_USUARIO'] }}">
                        <i class="fas fa-edit" style="font-size: 13px; color: cyan;"></i> Editar
                    </button>
                   <!-- boton eliminar-->
                    <button value="editar" title="Eliminar" class="btn btn-outline-danger" type="button" data-toggle="modal"
                     data-target="#usuarios-delete-{{$usuarios['COD_USUARIO']}}">
                     <i class='fas fa-trash-alt' style='font-size:13px;color:danger'></i> Eliminar
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