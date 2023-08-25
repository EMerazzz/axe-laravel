@extends('adminlte::page')

@section('title', 'Permisos')
@section('content_header')
<blockquote class="custom-blockquote">
    <p class="mb-0">Permisos registrados en el sistema AXE.</p>
    <footer class="blockquote-footer">Permisos<cite title="Source Title">Completadas</cite></footer>
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
<button type="button" class="btn btn-success btn-custom" data-toggle="modal" data-target="#permisos">+ Nuevo</button>
<div class="spacer"></div>
<div class="modal fade bd-example-modal-sm" id="permisos" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ingresa un Nuevo Permiso</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Ingrese los Datos:</p>
                    <form action="{{ url('permisos/insertar') }}" method="post">
                        @csrf
                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="PERMISO_INSERCION" name="PERMISO_INSERCION" value="1">
                        <label class="form-check-label" for="PERMISO_INSERCION">Permiso Insertar</label>
                        </div>

                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="PERMISO_ELIMINACION" name="PERMISO_ELIMINACION" value="1">
                        <label class="form-check-label" for="PERMISO_ELIMINACION">Permiso Eliminar</label>
                        </div>

                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="PERMISO_ACTUALIZACION" name="PERMISO_ACTUALIZACION" value="1">
                        <label class="form-check-label" for="PERMISO_ACTUALIZACION">Permiso Actualizar</label>
                        </div>

                        <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="PERMISO_CONSULTAR" name="PERMISO_CONSULTAR" value="1">
                        <label class="form-check-label" for="PERMISO_CONSULTAR">Permiso Consultar</label>
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

                        <div class="mb-3 mt-3">
                        <label for="MODIFICADO_POR" class="form-label">Modificado:</label>
                        <input type="text" class="form-control same-width" id="MODIFICADO_POR" name="MODIFICADO_POR" value="{{$UsuarioValue}}" readonly>
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
                    <th>Permiso Insertar</th>
                    <th>Permiso Eliminar</th>
                    <th>Permiso Actualizar</th>
                    <th>Permiso Consultar</th> 
                    <th>Fecha Creación</th>
                    <th>Modificado Por</th>
                    <th>Opciones de la Tabla</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permisosArreglo as $permisos)
                    <tr>
                        <td>{{ $permisos['COD_PERMISO'] }}</td>
                        <td>{{ $permisos['PERMISO_INSERCION'] }}</td>
                        <td>{{ $permisos['PERMISO_ELIMINACION'] }}</td>
                        <td>{{ $permisos['PERMISO_ACTUALIZACION'] }}</td>
                        <td>{{ $permisos['PERMISO_CONSULTAR'] }}</td>
                        <td>{{ $permisos['FECHA_CREACION'] }}</td>
                        <td>{{ $permisos['MODIFICADO_POR'] }}</td>
                        <td>
                            <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#permisos-edit-{{ $permisos['COD_PERMISO'] }}">
                                <i class='fas fa-edit' style='font-size:13px;color:cyan'></i> Editar
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @foreach($permisosArreglo as $permisos)
        <div class="modal fade bd-example-modal-sm" id="permisos-edit-{{ $permisos['COD_PERMISO'] }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Actualiza el permiso seleccionado</h5>
                        <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>Ingrese los Nuevos Datos</p>
                        <form action="{{ url('permisos/actualizar') }}" method="post">
                            @csrf
                            <input type="hidden" class="form-control" name="COD_PERMISO" value="{{ $permisos['COD_PERMISO'] }}">
                            <div>
                            <input type="checkbox" id="permiso_insercion" name="PERMISO_INSERCION" value="1" {{ $permisos['PERMISO_INSERCION'] === '1' ? 'checked' : '' }}>
                            <label for="permiso_insercion">Permiso Insertar</label>
                            </div>
                             
                            <div>
                            <input type="checkbox" id="permiso_eliminacion" name="PERMISO_ELIMINACION" value="1" {{ $permisos['PERMISO_ELIMINACION'] === '1' ? 'checked' : '' }}>
                            <label for="permiso_eliminacion">Permiso Eliminar</label>
                             </div>

                            <div>
                            <input type="checkbox" id="permiso_actualizacion" name="PERMISO_ACTUALIZACION" value="1" {{ $permisos['PERMISO_ACTUALIZACION'] === '1' ? 'checked' : '' }}>
                            <label for="permiso_actualizacion">Permiso Actualizar</label>
                            </div>

                             <div>
                            <input type="checkbox" id="permiso_consultar" name="PERMISO_CONSULTAR" value="1" {{ $permisos['PERMISO_CONSULTAR'] === '1' ? 'checked' : '' }}>
                            <label for="permiso_consultar">Permiso Consultar</label>
                             </div>

                             <div class="mb-3 mt-3">
                             <label for="MODIFICADO_POR" class="form-label">Modificado:</label>
                             <input type="text" class="form-control same-width" id="MODIFICADO_POR" name="MODIFICADO_POR" value="{{$UsuarioValue}}" readonly>
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