@extends('adminlte::page')

@section('title', 'AXE')
@section('content_header')

<center>
    <h1>Detalles personas</h1>
</center>
<blockquote class="blockquote text-center">
    <p class="mb-0">Personas registradas en el sistema AXE.</p>
    <footer class="blockquote-footer">Personas <cite title="Source Title">Completados</cite></footer>
</blockquote>
@stop

@section('content')
<style>
    .same-width {
        width: 100%; /* El combobox ocupará el mismo ancho que el textbox */
    }
</style>

<style>
    .btn-custom {
        margin-top: 5px; /* Ajusta el valor según tus necesidades */
    }
</style>
<style>
    .spacer {
        height: 20px; /* Ajusta la altura según tus necesidades */
    }
</style>
<div class="spacer"></div>
<button type="button" class="btn btn-success btn-custom" data-toggle="modal" data-target="#personas">+ Nuevo</button>
<div class="spacer"></div>
<div class="modal fade bd-example-modal-sm" id="personas" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ingresa una Nueva Persona</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Ingrese los Datos:</p>
            </div>
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{url('personas/insertar')}}" method="post">
                        @csrf
                <!-- INICIO --->
                        <div class="mb-3 mt-3">
                            <label for="NOMBRE" class="form-label">Nombres de la persona:</label>
                            <input type="text" class="form-control same-width" id="NOMBRE" name="NOMBRE" placeholder="Ingrese los nombres de la persona">
                        </div>
                 <!-- FIN --->
                        <div class="mb-3 mt-3">
                                       <label for="personas" class="form-label">Apellidos:</label>
                                      <input type="text" class="form-control" id="APELLIDO" name="APELLIDO" placeholder="Ingrese los apellidos de la persona">
                         </div>
    <div class="mb-3 mt-3" >
      <label for="personas" class="form-label">Numeros de identidad:</label>
      <input type="text" class="form-control same-width" id="IDENTIDAD" name="IDENTIDAD" placeholder="Ingrese numero de identidad de la persona">
    </div>

    <div class="mb-3">
    <label for="personas" class="form-label">Género:</label>
    <select class="form-control same-width" id="GENERO" name="GENERO">
        <option value="M" selected>Masculino</option>
        <option value="F">Femenino</option>
    </select>
    </div>

<div class="mb-3">
  <label for="personas" class="form-label">Tipo persona:</label>
  <select class="form-control same-width" id="TIPO_PERSONA" name="TIPO_PERSONA">
    <option value="Estudiante" selected>Estudiante</option>
    <option value="Docente"selected>Docente</option>
    <option value="Padre o tutor"selected>Padre o tutor</option>
  </select>
</div>

<div class="mb-3">
    <label for="personas" class="form-label">Edad:</label>
    <input type="text" class="form-control same-width" id="EDAD" name="EDAD" placeholder="Ingrese la edad">
</div>
<div class="mb-3">
  <label for="personas" class="form-label">Fecha de nacimiento:</label>
  <input type="date" class="form-control same-width" id="FECHA_NACIMIENTO" name="FECHA_NACIMIENTO">
</div>

<div class="mb-3">
  <label for="personas" class="form-label">Fecha salida:</label>
  <input type="date" class="form-control same-width" id="FECHA_SALIDA" name="FECHA_SALIDA" placeholder="Ingrese fecha de salida">
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
    <table id="miTabla" class="table table-hover table-dark table-striped mt-1" style="border: 2px solid lime;">
    <thead>
        <th>#</th> 
        <th>Nombres</th> 
        <th>Apellidos</th>
        <th>Numero de identidad</th>
        <th>Genero</th>
        <th>Tipo de persona</th>
        <th>Edad</th>
        <th>Fecha nacimiento</th>
        <th>Fecha registro</th>
        <th>Fecha salida</th>
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
            <td>{{$personas['EDAD']}}</td>
            <td>{{date('d, M Y', strtotime($personas['FECHA_NACIMIENTO']))}}</td>
            <td>{{date('d, M Y', strtotime($personas['FECHA_REGISTRO']))}}</td>
            <td>{{$personas['FECHA_SALIDA']}}</td>
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
                                            <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" placeholder="Ingrese los nombres de la persona" value="{{$personas['NOMBRE']}}">
                                        </div>
                                        
                                        <div class="mb-3 mt-3">
                                       <label for="personas" class="form-label">Apellidos:</label>
                                      <input type="text" class="form-control" id="APELLIDO" name="APELLIDO" placeholder="Ingrese los apellidos de la persona"value="{{$personas['APELLIDO']}}">
                                      </div>
                                      <div class="mb-3">
  <label for="personas" class="form-label">Numeros de identidad:</label>
  <input type="text" class="form-control" id="" name="IDENTIDAD" placeholder="Ingrese numero de identidad de la persona"value="{{$personas['IDENTIDAD']}}">
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
  <label for="personas" class="form-label">Edad:</label>
  <input type="text" class="form-control" id="EDAD" name="EDAD" placeholder="Ingrese la edad"value="{{$personas['EDAD']}}">
</div>
<div class="mb-3">
  <label for="personas" class="form-label">Fecha de nacimiento:</label>
  <!-- Formatear la fecha de nacimiento con date() y strtotime() -->
  <?php $fecha_nacimiento_formateada = date('Y-m-d', strtotime($personas['FECHA_NACIMIENTO'])); ?>
  <input type="date" class="form-control" id="FECHA_NACIMIENTO" name="FECHA_NACIMIENTO" value="{{ $fecha_nacimiento_formateada }}">
</div>

<div class="mb-3">
  <label for="personas" class="form-label">Fecha de salida:</label>
  <!-- Formatear la fecha de nacimiento con date() y strtotime() -->
  <?php $fecha_salida_formateada = date('Y-m-d', strtotime($personas['FECHA_SALIDA'])); ?>
  <input type="date" class="form-control" id="FECHA_SALIDA" name="FECHA_SALIDA" value="{{ $fecha_salida_formateada }}">
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
    <!-- Agregar estilos para DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@stop

@section('js')
    
    <script> console.log('Hi!'); </script>
    <!-- Agregar scripts para DataTables -->
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
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
@stop