@extends('adminlte::page')

@section('title', 'Personas')
@section('content_header')



@section('content_header')
<style>
  .custom-blockquote {
    line-height: 0; /* Reducción de la altura */
    margin-top: -5px; 
    margin-bottom:-3px; /* Reducción del espacio inferior del bloquequote */
  }
</style>

 <blockquote class="custom-blockquote"> 
    <p class="mb-0">Personas registradas en el sistema AXE.</p>
</blockquote>

@stop


   

@section('content')
<!-- boton de cambiar modo 
<div class="d-flex justify-content-end align-items-center">
    <button id="mode-toggle" class="btn btn-info ms-2">
        <i class="fas fa-adjust"></i> Cambiar Modo
    </button>
</div>-->

<!-- <div class="d-flex justify-content-end align-items-center mt-3">
    <button id="export-pdf" class="btn btn-danger ms-2"onclick="generarPDF()">
        <i class="far fa-file-pdf"></i> Exportar a PDF
    </button>
    <div style="width: 10px;"></div>
    <button id="export-excel" class="btn btn-success ms-2" onclick="exportToExcel()">
        <i class="far fa-file-excel"></i> Exportar a Excel
    </button>
</div> -->
   
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
<div class="modal fade bd-example-modal-lg" id="personas" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Ingresa una Nueva Persona</h4>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" style="background-color: #fff; padding: 20px;">

                <!-- Pestañas de Secciones -->
                <ul class="nav nav-tabs" id="seccionesTabs">
                    <li class="nav-item">
                        <a class="nav-link active" id="tabPersona" data-toggle="tab" href="#sectionPersona">Información Persona</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tabTelefonos" data-toggle="tab" href="#sectionTelefonos">Teléfono</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tabCorreo" data-toggle="tab" href="#sectionCorreo">Correo eléctronico</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tabDirecciones" data-toggle="tab" href="#sectionDirecciones">Dirección</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="tabContacto" data-toggle="tab" href="#sectionContacto">Contacto emergencia</a>
                    </li>
                   
                </ul>
                <form action="{{url('personas/insertar')}}" method="post">
                        @csrf
                <!-- Contenido de las Secciones -->
                <div class="tab-content">
                    <!-- Sección 1: Información de Persona -->
                    <div id="sectionPersona" class="tab-pane fade show active">
                        
                    <div id="sectionPersona" class="form-section">
                    
                        <div class="mb-3 mt-3">
                            <label for="NOMBRE" class="form-label">Nombres:</label>
                            <input type="text" class="form-control same-width" id="NOMBRE" name="NOMBRE" placeholder="Ingrese los nombres de la persona" inputmode="text" required value="{{ old('NOMBRE') }}" maxlength="40">
                            <div id="error-message-nombre" class="error-message" style="color: red; display: none;">Solo se permiten letras y espacios</div>
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="APELLIDO" class="form-label">Apellidos:</label>
                            <input type="text" class="form-control same-width" id="APELLIDO" name="APELLIDO" placeholder="Ingrese los apellidos de la persona" inputmode="text" required value="{{ old('APELLIDO') }}" maxlength="40">
                            <div id="error-message-apellido" style="color: red; display: none;">Solo se permiten letras y espacios</div>
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="IDENTIDAD" class="form-label">Número Identidad:</label>
                            <input type="text" class="form-control same-width" id="IDENTIDAD" name="IDENTIDAD" placeholder="____-____-_____" required>
                            <div id="error-message-identidad" style="color: red; display: none;">Solo se permiten números</div>
                        </div>

                        <div class="mb-3">
                            <label for="personas" class="form-label">Género:</label>
                            <select class="form-control same-width" id="GENERO" name="GENERO">
                                <option value="M" {{ old('GENERO') == 'M' ? 'selected' : '' }}>Masculino</option>
                                <option value="F" {{ old('GENERO') == 'F' ? 'selected' : '' }}>Femenino</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="personas" class="form-label">Tipo Persona:</label>
                            <select class="form-control same-width" id="TIPO_PERSONA" name="TIPO_PERSONA">
                                <option value="Estudiante" {{ old('TIPO_PERSONA') == 'Estudiante' ? 'selected' : '' }}>Estudiante</option>
                                <option value="Docente" {{ old('TIPO_PERSONA') == 'Docente' ? 'selected' : '' }}>Docente</option>
                                <option value="Padre o tutor" {{ old('TIPO_PERSONA') == 'Padre o tutor' ? 'selected' : '' }}>Padre o tutor</option>
                                <option value="Personal Administrativo" {{ old('TIPO_PERSONA') == 'Personal Administrativo' ? 'selected' : '' }}>Personal Administrativo</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="personas" class="form-label">Fecha Nacimiento:</label>
                            @php
                                $fechaNacimiento = old('FECHA_NACIMIENTO');
                                if ($fechaNacimiento) {
                                    $fechaNacimiento = date('Y-m-d', strtotime($fechaNacimiento));
                                }
                                // Calcular la fecha máxima permitida (5 años antes de la fecha actual)
                                $fechaMaxima = date('Y-m-d', strtotime('-5 years'));
                            @endphp
                            <input type="date" class="form-control same-width" id="FECHA_NACIMIENTO" name="FECHA_NACIMIENTO" value="{{ $fechaNacimiento }}" max="{{ $fechaMaxima }}">
                        </div>
                 </div>
                     </div>

                       <!-- Sección 2: Teléfonos -->
                      <div id="sectionTelefonos" class="tab-pane fade">
                       <div class="mb-3 mt-3">
                        <label for="TELEFONO" class="form-label">Número Teléfono:</label>
                        <input type="text" class="form-control" id="TELEFONO" name="TELEFONO" placeholder="____-____" required>
                       </div>
                        <div class="mb-3">
                            <label for="TIPO_TELEFONO" class="form-label">Tipo Teléfono:</label>
                            <select class="form-control same-width" id="TIPO_TELEFONO" name="TIPO_TELEFONO">
                                <option value="Fijo" selected>Fijo</option>
                                <option value="Movil">Móvil</option>
                            </select>
                        </div>
                    </div>

                    <!-- Sección 3: Direcciones -->
                    <div id="sectionDirecciones" class="tab-pane fade">
                    <div class="mb-3 mt-3">
                            <label for="PAIS" class="form-label">País</label>
                            <input type="text" class="form-control" id="PAIS" name="PAIS" placeholder="Ingrese el país" required maxlength="30" 
                            title="Solo se permiten letras y espacios"   oninput="this.value = this.value.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g, '')" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="DEPARTAMENTO" class="form-label">Departamento</label>
                            <input type="text" class="form-control" id="DEPARTAMENTO" name="DEPARTAMENTO" placeholder="Ingrese el departamento" required maxlength="35"
                            title="Solo se permiten letras y espacios"   oninput="this.value = this.value.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g, '')" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="CIUDAD" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" id="CIUDAD" name="CIUDAD" placeholder="Ingrese la ciudad" required maxlength="30"
                             title="Solo se permiten letras y espacios"   oninput="this.value = this.value.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g, '')" required>
                            </div>
                            <div class="mb-3 mt-3">
                                <label for="direcciones" class="form-label">Dirección</label>
                                <textarea class="form-control" id="DIRECCION" name="DIRECCION" placeholder="Ingrese la dirección" required maxlength="250" style="height: 100px;"></textarea>
                            </div>

                    </div>
                    <!-- Sección 4: Contactos emergencia -->
                    <div id="sectionContacto" class="tab-pane fade">
                    <div class="mb-3 mt-3">
                            <label for="contacto" class="form-label">Nombre Contacto:</label>
                            <input type="text" class="form-control" id="NOMBRE_CONTACTO" name="NOMBRE_CONTACTO" placeholder="Ingrese el nombre del contacto"required maxlength="40">
                            <div id="error-message-nombreC" style="color: red; display: none;">Solo se permiten letras y espacios</div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="contacto" class="form-label">Apellidos Contacto:</label>
                            <input type="text" class="form-control" id="APELLIDO_CONTACTO" name="APELLIDO_CONTACTO" placeholder="Ingrese los apellidos del contacto"required maxlength="40">
                            <div id="error-message-apellidoC" style="color: red; display: none;">Solo se permiten letras y espacios</div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="contacto" class="form-label">Teléfono Contacto Emergencia:</label>
                            <input type="text" class="form-control" id="TELEFONO_CONTACTO" name="TELEFONO_CONTACTO" placeholder="Ingrese el Número de télefono contacto emergencia" required maxlength="15">
                            <div id="error-message-telefono" style="color: red; display: none;">Solo se permiten números</div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="contacto" class="form-label">Relación:</label>
                            <input type="text" class="form-control" id="RELACION" name="RELACION" placeholder="Ingrese la relación" required maxlength="25">
                            <div id="error-message-relacion" style="color: red; display: none;">Solo se permiten letras y espacios</div>
                        </div>

                   </div>
                   <!-- Sección 4: correos -->
                   <div id="sectionCorreo" class="tab-pane fade">
                         <div class="mb-3 mt-3">
                            <label for="correos" class="form-label">Correo Electrónico</label>
                            <input type="text" class="form-control" id="CORREO_ELECTRONICO" name="CORREO_ELECTRONICO" placeholder="Ingrese el correo electrónico" required maxlength="45" oninput="this.value = this.value.replace(/\s/g, '');">
                            
                        </div>
                   </div>

                </div>
            </div>

            <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Añadir</button>

              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>

            </div>
            </form>
        </div>
    </div>
</div>

<script>
    var currentSection = 1;

    function nextSection() {
        hideAllSections();
        currentSection++;
        showCurrentSection();
    }

    function prevSection() {
        hideAllSections();
        currentSection--;
        showCurrentSection();
    }

    function showCurrentSection() {
        var sectionId = 'section' + currentSection;
        document.getElementById('seccionesTabs').querySelectorAll('.nav-link').forEach(function (tab) {
            tab.classList.remove('active');
        });
        document.getElementById('tab' + sectionId).classList.add('active');
        document.getElementById(sectionId).classList.add('show', 'active');
    }

    function hideAllSections() {
        for (var i = 1; i <= 5; i++) { // Actualiza el rango según el número de secciones
            var sectionId = 'section' + i;
            document.getElementById(sectionId).classList.remove('show', 'active');
        }
    }
</script>

<div class="table-responsive">
<table id="miTabla" class="table table-hover table-light table-striped mt-1" style="border:2px solid lime;">
    <thead>
        <th>#</th> 
        <th>Nombres</th> 
        <th>Apellidos</th>
        <th>Identidad</th>
        <th>Género</th>
        <th>Tipo Persona</th>
        <th>Fecha nacimiento</th>
        <th>Edad</th>
        <th>Fecha registro</th>
        <th>Opciones Tabla</th>
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
            <td>{{date('d, M Y', strtotime($personas['FECHA_NACIMIENTO']))}}</td>
            <td>{{date_diff(date_create($personas['FECHA_NACIMIENTO']), date_create('today'))->y}}</td>
            <td>{{date('d, M Y', strtotime($personas['FECHA_REGISTRO']))}}</td>
            
            <td>
            
              <!-- Botones -->
                <div class="btn-group" role="group" aria-label="Acciones">
                    <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal" data-target="#personas-edit-{{$personas['COD_PERSONA']}}">
                        <i class='fas fa-edit' style='font-size:13px;color:cyan'></i> 
                    </button>

                    <button title="Ver" class="btn btn-outline-info ver-btn" type="button" data-toggle="modal" data-target="#ver-persona-modal-{{ $personas['COD_PERSONA'] }}">
                        <i class='fas fa-eye' style='font-size:13px;color:blue'></i> 
                    </button>
                    <button value="editar" title="Eliminar" class="btn btn-outline-danger" type="button" data-toggle="modal"
                          data-target="#personas-delete-{{$personas['COD_PERSONA']}}">
                           <i class='fas fa-trash-alt' style='font-size:13px;color:danger'></i> 
                   </button>
                </div>

                   
             
        <!-- Modal de Edición con Pestañas -->
<div class="modal fade bd-example-modal-lg" id="personas-edit-{{$personas['COD_PERSONA']}}" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualiza la persona seleccionada</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body" style="background-color: #fff; padding: 20px;">

                <!-- Pestañas de Secciones -->
                <ul class="nav nav-tabs" id="editSeccionesTabs{{$personas['COD_PERSONA']}}">
                    <li class="nav-item">
                        <a class="nav-link active" id="editTabPersona{{$personas['COD_PERSONA']}}" data-toggle="tab" href="#editSectionPersona{{$personas['COD_PERSONA']}}">Información Persona</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="editTabTelefonos{{$personas['COD_PERSONA']}}" data-toggle="tab" href="#editSectiontelefono{{$personas['COD_PERSONA']}}">Teléfono</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="editTabCorreo{{$personas['COD_PERSONA']}}" data-toggle="tab" href="#editSectioncorreos{{$personas['COD_PERSONA']}}">Correo electrónico</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="editTabDirecciones{{$personas['COD_PERSONA']}}" data-toggle="tab" href="#editSectiondirecciones{{$personas['COD_PERSONA']}}">Dirección</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="editTabContacto{{$personas['COD_PERSONA']}}" data-toggle="tab" href="#editSectioncontacto{{$personas['COD_PERSONA']}}">Contacto emergencia</a>
                    </li>
                </ul>

                <form action="{{url('personas/actualizar')}}" method="post">
                    @csrf
                    <input type="hidden" class="form-control" name="COD_PERSONA" value="{{$personas['COD_PERSONA']}}">

                    <!-- Contenido de las Secciones -->
                    <div class="tab-content">
                        <!-- Sección 1: Información de Persona -->
                        <div id="editSectionPersona{{$personas['COD_PERSONA']}}" class="tab-pane fade show active">
                        <input type="hidden" class="form-control" name="COD_PERSONAS¿" value="{{ $personas['COD_PERSONA'] }}">
                            <div class="mb-3 mt-3">
                                <label for="NOMBRE" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" placeholder="Ingrese los nombres de la persona" value="{{$personas['NOMBRE']}}" maxlength="40" 
                                title="Solo se permiten letras y espacios" oninput="this.value = this.value.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g, '')" required>
                            </div>
                                        
                        <div class="mb-3 mt-3">
                            <label for="APELLIDO" class="form-label">Apellido:</label>
                            <input type="text" class="form-control" id="APELLIDO" name="APELLIDO" placeholder="Ingrese los apellidos de la persona" value="{{$personas['APELLIDO']}}" maxlength="40"
                            title="Solo se permiten letras y espacios"   oninput="this.value = this.value.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g, '')" required>
                        </div>
                                        
                        <div class="mb-3">
                            <label for="IDENTIDAD" class="form-label">Número Identidad:</label>
                            <input type="text" class="form-control" id="IDENTIDAD" name="IDENTIDAD" placeholder="--_" value="{{$personas['IDENTIDAD']}}" maxlength="15" title="Solo se permiten números" oninput="formatIdentidad(this)" required>
                        </div>

                        <div class="mb-3">
                        <label for="personas" class="form-label">Tipo Persona:</label>
                        <select class="form-control same-width" id="TIPO_PERSONA" name="TIPO_PERSONA">
                            <option value="Estudiante" {{ $personas['TIPO_PERSONA'] === 'Estudiante' ? 'selected' : '' }}>Estudiante</option>
                            <option value="Docente" {{ $personas['TIPO_PERSONA'] === 'Docente' ? 'selected' : '' }}>Docente</option>
                            <option value="Padre o tutor" {{ $personas['TIPO_PERSONA'] === 'Padre o tutor' ? 'selected' : '' }}>Padre o tutor</option>
                            <option value="Personal Administrativo" {{ $personas['TIPO_PERSONA'] === 'Personal Administrativo' ? 'selected' : '' }}>Personal Administrativo</option>
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
                        <label for="personas" class="form-label">Fecha Nacimiento:</label>
                        <?php
                            // Formatear la fecha de nacimiento
                            $fecha_nacimiento_formateada = date('Y-m-d', strtotime($personas['FECHA_NACIMIENTO']));

                            // Calcular la fecha máxima permitida (5 años antes de la fecha actual)
                            $fecha_maxima = date('Y-m-d', strtotime('-5 years'));

                            echo '<input type="date" class="form-control" id="FECHA_NACIMIENTO" name="FECHA_NACIMIENTO" value="' . $fecha_nacimiento_formateada . '" max="' . $fecha_maxima . '">';
                        ?>
                        </div>
                        </div>
                        <!-- Fin Sección 1 -->

                        <!-- Sección 2: Teléfono -->
                        <div id="editSectiontelefono{{$personas['COD_PERSONA']}}" class="tab-pane fade">
                          
                        <input type="text" class="form-control" id="TELEFONO" name="TELEFONO" placeholder="____-____" oninput="formatTelefono(this)" pattern="[0-9]{4}-[0-9]{4}" value="{{ $personas['TELEFONO'] }}" required>


                        <div class="mb-3">
                            <label for="TIPO_TELEFONO" class="form-label">Tipo Telefono:</label>
                            <select class="form-control same-width" id="TIPO_TELEFONO" name="TIPO_TELEFONO">
                                <option value="Fijo" {{ $personas['TIPO_TELEFONO'] === 'Fijo' ? 'selected' : '' }}>Fijo</option>
                                <option value="Movil" {{ $personas['TIPO_TELEFONO'] === 'Movil' ? 'selected' : '' }}>Movil</option>
                            </select>
                        </div>
                            <!-- ... -->
                        </div>
                        <!-- Fin Sección 2 -->

                        <!-- Sección 3: Correo electrónico -->
                        <div id="editSectioncorreos{{$personas['COD_PERSONA']}}" class="tab-pane fade">
                        <div class="mb-3 mt-3">
                            <label for="correos" class="form-label">Correo electrónico</label>
                            <input type="text" class="form-control" id="CORREO_ELECTRONICO" name="CORREO_ELECTRONICO" placeholder="Ingrese el correo electrónico" value="{{ $personas['CORREO_ELECTRONICO'] }}" required maxlength="45"
                            title="No se permiten espacios" oninput="this.value = this.value.replace( /\s/g, '')" required>
                        </div>
        
                        </div>
                        <!-- Fin Sección 3 -->

                        <!-- Sección 4: Direcciones -->
                        <div id="editSectiondirecciones{{$personas['COD_PERSONA']}}" class="tab-pane fade">
                        <div class="mb-3 mt-3">
                            <label for="direcciones" class="form-label">país</label>
                            <input type="text" class="form-control" id="PAIS" name="PAIS" placeholder="Ingrese el país" value="{{ $personas['PAIS'] }}" maxlength="40"
                            title="Solo se permiten letras y espacios"   oninput="this.value = this.value.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g, '')" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="direcciones" class="form-label">Departamento</label>
                            <input type="text" class="form-control" id="DEPARTAMENTO" name="DEPARTAMENTO" placeholder="Ingrese el departamento" value="{{ $personas['DEPARTAMENTO'] }}" maxlength="40"
                            title="Solo se permiten letras y espacios"   oninput="this.value = this.value.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g, '')" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="direcciones" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" id="CIUDAD" name="CIUDAD" placeholder="Ingrese la ciudad" value="{{ $personas['CIUDAD'] }}" maxlength="40"
                            title="Solo se permiten letras y espacios"   oninput="this.value = this.value.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g, '')" required>
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="direcciones" class="form-label">Dirección</label>
                            <textarea class="form-control" id="DIRECCION" name="DIRECCION" placeholder="Ingrese la dirección" required maxlength="255">{{ $personas['DIRECCION'] }}</textarea>
                        </div>

                        </div>
                        <!-- Fin Sección 4 -->

                        <!-- Sección 5: Contacto -->
                        <div id="editSectioncontacto{{$personas['COD_PERSONA']}}" class="tab-pane fade">
                          
                        <div class="mb-3 mt-3">
                            <label for="contacto" class="form-label">Nombre contacto</label>
                            <input type="text" class="form-control" id="NOMBRE_CONTACTO" name="NOMBRE_CONTACTO" placeholder="Ingrese el nombre del contacto " value="{{ $personas['NOMBRE_CONTACTO'] }}" maxlength="40"
                            title="Solo se permiten letras y espacios" oninput="this.value = this.value.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g, '')" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="contacto" class="form-label">Apellidos Contacto</label>
                            <input type="text" class="form-control" id="APELLIDO_CONTACTO" name="APELLIDO_CONTACTO" placeholder="Ingrese los apellidos del contacto" value="{{ $personas['APELLIDO_CONTACTO'] }}" maxlength="40"
                             title="Solo se permiten letras y espacios" oninput="this.value = this.value.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g, '')" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="contacto" class="form-label">Teléfono Contacto Emergencia</label>
                            <input type="text" class="form-control" id="TELEFONO" name="TELEFONO" placeholder="Ingrese el Número de télefono contacto emergencia" value="{{ $personas['TELEFONO_CONTACTO'] }}" maxlength="15"
                             title="Solo se permiten números"  oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="contacto" class="form-label">Relación</label>
                            <input type="text" class="form-control" id="RELACION" name="RELACION" placeholder="Ingrese la relación" value="{{ $personas['RELACION'] }}"maxlength="25"
                            title="Solo se permiten letras y espacios" oninput="this.value = this.value.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g, '')" required>
                        </div>
        

                        </div>
                        <!-- Fin Sección 5 -->
                    </div>
                    <!-- Fin Contenido de las Secciones -->

                
            </div>
            <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                      
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </div>
                    </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('[id^="editSeccionesTabs"]').each(function () {
            var tabId = $(this).attr('id');
            $('#' + tabId + ' a').on('click', function (e) {
                e.preventDefault();
                $(this).tab('show');
            });
        });
    });
</script>

<!-- Fin Modal de Edición con Pestañas -->

       <!-- modal ver -->

<!-- Modal para mostrar detalles de la persona -->
<div class="modal fade" id="ver-persona-modal-{{ $personas['COD_PERSONA'] }}" tabindex="-1" role="dialog" aria-labelledby="verPersonaModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verPersonaModal">Detalles de la Persona</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"style="background-color: #fff; padding: 20px;">
            
                <p><strong>Nombre completo:</strong> {{ $personas['NOMBRE'] }} {{ $personas['APELLIDO'] }}</p>
                <p><strong>Identidad:</strong> {{$personas['IDENTIDAD']}}</p>
                <!-- INICIO-->
                <p><strong>Número télefonico:</strong>  {{ $personas['TELEFONO']}} </p>
                 <!-- FIN-->
              <!-- INICIO-->
              @php
                    $correo = null;
                    foreach ($correosArreglo as $c) {
                        if ($c['COD_PERSONA'] === $personas['COD_PERSONA']) {
                            $correo= $c;
                            break;
                        }
                    }
                @endphp
                <p><strong>Correo electrónico:</strong>  
                       @if ($correo !== null)
                         {{ $correo['CORREO_ELECTRONICO']}}
                      
                        @endif 
                    </p>
                 <!-- FIN-->
                 <!-- INICIO-->
                 @php
                    $direccion = null;
                    foreach ($direccionesArreglo as $d) {
                        if ($d['COD_PERSONA'] === $personas['COD_PERSONA']) {
                            $direccion= $d;
                            break;
                        }
                    }
                @endphp
                <p><strong>Dirección:</strong>  
                       @if ($direccion !== null)
                         {{ $direccion['DEPARTAMENTO']}}, {{ $direccion['CIUDAD']}}, {{ $direccion['DIRECCION']}}
                      
                        @endif 
                    </p>
                 <!-- FIN-->
                  <!-- INICIO-->
                  @php
                    $contacto = null;
                    foreach ($contactosArreglo as $c) {
                        if ($c['COD_PERSONA'] === $personas['COD_PERSONA']) {
                            $contacto= $c;
                            break;
                        }
                    }
                @endphp
                <p><strong>Nombre contacto de emergencia:</strong>  
                       @if ($contacto !== null)
                         {{ $contacto['NOMBRE_CONTACTO']}}  {{ $contacto['APELLIDO_CONTACTO']}} 
                       
                        @endif 
                    </p>
                    <p><strong>Numero Telefónico contacto de emergencia:</strong>  
                       @if ($contacto !== null)
                         {{ $contacto['TELEFONO']}} 
                       
                        @endif 
                    </p>
                    <p><strong>Relación con la persona:</strong>  
                       @if ($contacto !== null)
                         {{ $contacto['RELACION']}} 
                       
                        @endif 
                    </p>
                 <!-- FIN-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- modal ver-->               


<!-- modal ELiminar-->
<!-- modal ELiminar-->
        <!-- Empieza modal eliminar -->
        <div class="modal fade bd-example-modal-sm" id="personas-delete-{{$personas['COD_PERSONA']}}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Atención</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="background-color: #fff; padding: 20px;">
                <h5 class="modal-title">¿Desea eliminar este registro?</h5>
            </div>
            <div class="modal-footer">
            <form action="{{ url('personas/delete') }}" method="post">
                        @csrf
      <input type="hidden" class="form-control" name="COD_PERSONA" value="{{ $personas['COD_PERSONA'] }}">
              <button  class="btn btn-danger">Si</button>
          </form>
        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        
            </div>
        </div>
    </div>
</div>
<!-- modal Eliminar -->

 
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
   <!-- Reportes -->
  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.min.js"></script>


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
    setupValidation('NOMBRE', 'error-message-nombre', /[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g);
    // Configuración para el campo de APELLIDO
    setupValidation('APELLIDO', 'error-message-apellido', /[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g);
    // Configuración para el campo de IDENTIDAD
    setupValidation('IDENTIDAD', 'error-message-identidad', /[^0-9]/g);
       // Configuración para el campo de NOMBRE
       setupValidation('NOMBRE_CONTACTO', 'error-message-nombreC', /[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g);
    // Configuración para el campo de APELLIDO
    setupValidation('APELLIDO_CONTACTO', 'error-message-apellidoC', /[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g);
     // Configuración para el campo de RELACION
     setupValidation('RELACION', 'error-message-relacion', /[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g);
    // Configuración para el campo de DEPARTAMENTO
    setupValidation('DEPARTAMENTO', 'error-message-departamento', /[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g);
    // Configuración para el campo de CIUDAD
    setupValidation('CIUDAD', 'error-message-ciudad', /[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g);
    // Configuración para el campo de PAIS
    setupValidation('PAIS', 'error-message-pais', /[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g);
    // Configuración para el campo de CORREO_ELECTRONICO
    setupValidation('CORREO_ELECTRONICO', 'error-message-correo', /\s/g); // Evita espacios en blanco
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
<!-- ********************************************************* -->
<!-- Script generar reportes excel y pdf -->
<script>
  function generarPDF() {
    const tableData = [];
    const headerData = [];

    // Obtén los datos del encabezado de la tabla (excluyendo la columna "Opciones de la Tabla")
    const tableHeader = document.querySelectorAll('#miTabla thead th');
    tableHeader.forEach(headerCell => {
        if (headerCell.textContent !== 'Opciones de la Tabla') {
            headerData.push({ text: headerCell.textContent, bold: true });
        }
    });

    // Obtén todos los datos de la tabla, incluyendo todas las páginas
    const table = $('#miTabla').DataTable();
    const allData = table.rows().data();
    
    allData.each(function (rowData) {
        const row = [];
        rowData.forEach((cell, index) => {
            // Excluir la última columna y la columna "Opciones de la Tabla"
            if (headerData[index] && index !== rowData.length - 1) {
                row.push(cell);
            }
        });
        tableData.push(row);
    });

    const documentDefinition = {
        pageOrientation: 'landscape', // Establece la orientación de la página a horizontal
        content: [
            {
                text: 'Reporte de Tabla en PDF',
                fontSize: 16,
                bold: true,
                alignment: 'center',
                margin: [0, 0, 0, 10]
            },
            {
                table: {
                    headerRows: 1,
                    widths: Array(headerData.length).fill('auto'),
                    body: [
                        headerData, // Encabezado de la tabla
                        ...tableData // Datos de la tabla
                    ],
                    style: {
                        lineHeight: 1.2 // Ajusta este valor para reducir o aumentar el espacio entre filas
                    }
                }
            }
        ]
    };

    pdfMake.createPdf(documentDefinition).download('reporte.pdf');
}

function exportToExcel() {
    const tableData = [];
    const headerData = [];

    // Obtén los datos del encabezado de la tabla (excluyendo la columna "Opciones de la Tabla")
    const tableHeader = document.querySelectorAll('#miTabla thead th');
    tableHeader.forEach(headerCell => {
        if (headerCell.textContent !== 'Opciones de la Tabla') {
            headerData.push(headerCell.textContent);
        }
    });

    // Obtén todos los datos de la tabla, incluyendo todas las páginas
    const table = $('#miTabla').DataTable();
    const allData = table.rows().data();
    
    allData.each(function (rowData) {
        const row = [];
        rowData.forEach((cell, index) => {
            // Excluir la última columna y la columna "Opciones de la Tabla"
            if (index !== rowData.length - 1) {
                row.push(cell);
            }
        });
        tableData.push(row);
    });

    const worksheetData = [headerData, ...tableData];

    // Crear un objeto WorkBook y hoja de cálculo
    const wb = XLSX.utils.book_new();
    const ws = XLSX.utils.aoa_to_sheet(worksheetData);

    // Agregar la hoja de cálculo al WorkBook
    XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

    // Generar el archivo Excel como una matriz binaria
    const excelBinary = XLSX.write(wb, { bookType: 'xlsx', type: 'binary' });

    // Convertir la matriz binaria en un Blob
    const excelBlob = new Blob([s2ab(excelBinary)], {
        type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    });

    // Descargar el archivo usando la biblioteca FileSaver.js
    saveAs(excelBlob, 'reporte.xlsx');
}

// Función para convertir una cadena binaria en una matriz de bytes
function s2ab(s) {
    const buf = new ArrayBuffer(s.length);
    const view = new Uint8Array(buf);
    for (let i = 0; i !== s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
    return view;
}

</script>

<script>
// Asegúrate de que jQuery esté cargado y disponible
$(document).ready(function () {
    // Aplica el formato deseado con inputmask.js
    $('#IDENTIDAD').inputmask('9999-9999-99999');
});
</script>
<script>
function formatIdentidad(input) {
    // Elimina cualquier guión o caracteres no numéricos del valor del campo
    let value = input.value.replace(/-/g, '').replace(/\D/g, '');

    // Formatea el valor con guiones después de cada grupo de 4 caracteres
    let formattedValue = "";
    for (let i = 0; i < value.length; i++) {
        if (i === 4 || i === 8) {
            formattedValue += '-';
        }
        formattedValue += value.charAt(i);
    }

    // Asigna el valor formateado de vuelta al campo de entrada
    input.value = formattedValue;
}
</script>
<script>
    document.getElementById('TELEFONO').addEventListener('input', function () {
        let input = this;
        let value = input.value.replace(/\D/g, ''); // Elimina caracteres no numéricos

        // Formatea el número de teléfono
        if (value.length >= 4) {
            input.value = value.slice(0, 4) + '-' + value.slice(4, 8);
        } else {
            input.value = value;
        }
    });
</script>
<script>
    document.getElementById('TELEFONO_CONTACTO').addEventListener('input', function () {
        let input = this;
        let value = input.value.replace(/\D/g, ''); // Elimina caracteres no numéricos

        // Formatea el número de teléfono
        if (value.length >= 4) {
            input.value = value.slice(0, 4) + '-' + value.slice(4, 8);
        } else {
            input.value = value;
        }
    });
</script>
<script>
 function formatTelefono(input) {
    // Elimina cualquier carácter no numérico
    let cleanedValue = input.value.replace(/\D/g, '');

    // Asegura que la longitud sea de 8 caracteres
    if (cleanedValue.length > 8) {
        cleanedValue = cleanedValue.slice(0, 8);
    }

    // Formatea el valor con guiones después de cada grupo de 4 caracteres
    let formattedValue = '';
    for (let i = 0; i < cleanedValue.length; i++) {
        if (i === 4) {
            formattedValue += '-';
        }
        formattedValue += cleanedValue.charAt(i);
    }

    // Asigna el valor formateado de vuelta al campo de entrada
    input.value = formattedValue;
}

</script>

@stop