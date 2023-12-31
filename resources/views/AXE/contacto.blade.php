@extends('adminlte::page')

@section('title', 'Contactos emergencia')

@section('content_header')
<style>
  .custom-blockquote {
    line-height: 0; /* Reducción de la altura */
    margin-top: -5px; 
    margin-bottom:-5px; /* Reducción del espacio inferior del bloquequote */
  }
</style>
<blockquote class="custom-blockquote">
    <p class="mb-0">Contactos de emergencia registrados en el sistema AXE.</p>
</blockquote>

@stop

@section('content')
<!-- Cambiar Modo
<div class="d-flex justify-content-end align-items-center">
    <button id="mode-toggle" class="btn btn-info ms-2" style="margin-top: 10px; margin-bottom: -60px;">
        <i class="fas fa-adjust"></i> Cambiar Modo
    </button>--->
    <div class="text-center mt-3">
    <!-- Grupo de PDF -->
    <div class="d-inline-block align-items-center">
        <button id="export-pdf" class="btn btn-danger" onclick="generarPDF()" style="margin-right: 8px;">
            <i class="far fa-file-pdf"></i> Exportar a PDF
        </button>
    </div>

    <!-- Grupo de Excel -->
    <div class="d-inline-block align-items-center">
        <button id="export-excel" class="btn btn-success" onclick="exportToExcel()" style="margin-left: 8px;">
            <i class="far fa-file-excel"></i> Exportar a Excel
        </button>
    </div>
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
<!-- Boton
<button type="button" class="btn btn-success btn-custom" data-toggle="modal" data-target="#personas">+ Nuevo</button>--->
<div class="spacer"></div>
<div class="modal fade bd-example-modal-sm" id="personas" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ingresa Contacto emergencia</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>   
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{ url('contacto/insertar') }}" method="post">
                        @csrf
                        <!-- INICIO --->
                        <div class="mb-3 mt-3">
                            <label for="COD_PERSONA" class="form-label">Persona: </label>
                            <select class="selectize" id="COD_PERSONA" name="COD_PERSONA" required>
                                <option value="" disabled selected>Seleccione Persona</option>
                                @foreach ($personasArreglo as $persona)
                                    <option value="{{ $persona['COD_PERSONA'] }}">{{ $persona['NOMBRE'] }} {{ $persona['APELLIDO'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- FIN --->
                        <div class="mb-3 mt-3">
                            <label for="contacto" class="form-label">Nombre Contacto:</label>
                            <input type="text" class="form-control" id="NOMBRE_CONTACTO" name="NOMBRE_CONTACTO" placeholder="Ingrese el nombre del contacto"required maxlength="40">
                            <div id="error-message-nombre" style="color: red; display: none;">Solo se permiten letras y espacios</div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="contacto" class="form-label">Apellidos Contacto:</label>
                            <input type="text" class="form-control" id="APELLIDO_CONTACTO" name="APELLIDO_CONTACTO" placeholder="Ingrese los apellidos del contacto"required maxlength="40">
                            <div id="error-message-apellido" style="color: red; display: none;">Solo se permiten letras y espacios</div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="contacto" class="form-label">Teléfono Contacto Emergencia:</label>
                            <input type="text" class="form-control" id="TELEFONO" name="TELEFONO" placeholder="Ingrese el Número de télefono contacto emergencia" required maxlength="15">
                            <div id="error-message-telefono" style="color: red; display: none;">Solo se permiten números</div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="contacto" class="form-label">Relación:</label>
                            <input type="text" class="form-control" id="RELACION" name="RELACION" placeholder="Ingrese la relación" required maxlength="25">
                            <div id="error-message-relacion" style="color: red; display: none;">Solo se permiten letras y espacios</div>
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
                <th>Nombre Persona</th>
                <th>Nombre contacto</th>
                <th>Apellido contacto</th>
                <th>Número Telefono Contacto</th>
                <th>Relación</th>
                <th>Fecha Registro</th>
                <th>Estado Registro</th>
                <th>Opciones Tabla</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contactoArreglo as $contacto)
            <tr>
            @php
                    $persona = null;
                    foreach ($personasArreglo as $p) {
                        if ($p['COD_PERSONA'] === $contacto['COD_PERSONA']) {
                            $persona = $p;
                            break;
                        }
                    }
                @endphp
                <td>{{ $contacto['COD_CONTACTO_EMERGENCIA'] }}</td>
                <td>
                        @if ($persona !== null)
                            {{ $persona['NOMBRE'] . ' ' . $persona['APELLIDO'] }}
                        @else
                            Persona no encontrada
                        @endif
                    </td>
                <td>{{ $contacto['NOMBRE_CONTACTO'] }}</td>
                <td>{{ $contacto['APELLIDO_CONTACTO'] }}</td>
                <td>{{ $contacto['TELEFONO'] }}</td>
                <td>{{ $contacto['RELACION'] }}</td>
                <td>{{ date('d, M Y', strtotime($contacto['FECHA'])) }}</td>

            
                <td>
                    @if($contacto['Estado_registro'] == 1)
                        Activo
                    @elseif($contacto['Estado_registro'] == 0)
                        Inactivo
                    @endif
                 </td>

                <td>
                    <button id="botonEditar_1" value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal"
                        data-target="#contacto-edit-{{ $contacto['COD_CONTACTO_EMERGENCIA'] }}">
                        <i class="fas fa-edit" style="font-size: 13px; color: cyan;"></i> Editar
                    </button>

                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@foreach($contactoArreglo as $contacto)
<div class="modal fade bd-example-modal-sm" id="contacto-edit-{{ $contacto['COD_CONTACTO_EMERGENCIA'] }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualiza Contacto</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <div class="d-grid gap-2 col-12 mx-auto">
                    <form action="{{ url('contacto/actualizar') }}" method="post">
                        @csrf
                        <input type="hidden" class="form-control" name="COD_CONTACTO_EMERGENCIA" value="{{ $contacto['COD_CONTACTO_EMERGENCIA'] }}">
                       <!-- <div class="mb-3 mt-3 d-flex align-items-center">
                            <label for="COD_PERSONA" class="form-label mr-5">Persona</label>
                            <select class="selectize" id="COD_PERSONA" name="COD_PERSONA" required>
                                @foreach ($personasArreglo as $persona)
                                    <option value="{{ $persona['COD_PERSONA'] }}" {{ $persona['COD_PERSONA'] == $contacto['COD_PERSONA'] ? 'selected' : '' }}>
                                        {{ $persona['NOMBRE'] }} {{ $persona['APELLIDO'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div> -->
                        <div class="mb-3 mt-3 d-flex align-items-center">
                            <label for="contacto" class="form-label mr-2 ml-1">Nombre contacto</label>
                            <input type="text" class="form-control" id="NOMBRE_CONTACTO" name="NOMBRE_CONTACTO" placeholder="Ingrese el nombre del contacto " value="{{ $contacto['NOMBRE_CONTACTO'] }}" maxlength="40"
                            title="Solo se permiten letras y espacios" oninput="this.value = this.value.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g, '')" required>
                        </div>
                        <div class="mb-3 mt-3 d-flex align-items-center">
                            <label for="contacto" class="form-label mr-2">Apellidos Contacto</label>
                            <input type="text" class="form-control" id="APELLIDO_CONTACTO" name="APELLIDO_CONTACTO" placeholder="Ingrese los apellidos del contacto" value="{{ $contacto['APELLIDO_CONTACTO'] }}" maxlength="40"
                             title="Solo se permiten letras y espacios" oninput="this.value = this.value.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g, '')" required>
                        </div>
                        <div class="mb-3 mt-3 d-flex align-items-center">
                            <label for="contacto" class="form-label">Contacto Emergencia</label>
                            <input type="text" class="form-control" id="TELEFONO" name="TELEFONO" placeholder="Ingrese el Número de télefono contacto emergencia" value="{{ $contacto['TELEFONO'] }}" maxlength="15"
                             title="Solo se permiten números"  oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                        </div>
                        <div class="mb-3 mt-3 d-flex align-items-center">
                            <label for="contacto" class="form-label mr-5">Relación</label>
                            <input type="text" class="form-control" id="RELACION" name="RELACION" placeholder="Ingrese la relación" value="{{ $contacto['RELACION'] }}"maxlength="25"
                            title="Solo se permiten letras y espacios" oninput="this.value = this.value.replace(/[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g, '')" required>
                        </div>
        

                        <button type="submit" class="btn btn-primary">Editar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- empieza modal eliminar -->
<div class="modal fade bd-example-modal-sm" id="contacto-delete-{{$contacto['COD_CONTACTO_EMERGENCIA']}}" tabindex="-1">
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
      <form action="{{ url('contacto/delete') }}" method="post">
                        @csrf
      <input type="hidden" class="form-control" name="COD_CONTACTO_EMERGENCIA" value="{{ $contacto['COD_CONTACTO_EMERGENCIA'] }}">
              <button  class="btn btn-danger">Si</button>
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
      <!-- Reportes -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
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
    // Ejemplo de permisosDisponibles obtenido desde PHP
    var permisosDisponibles = <?php echo json_encode($permisosDisponibles); ?>;
    
    var permisoConsulta = permisosDisponibles[0]['PERMISO_CONSULTAR'];
    var permisoInsercion = permisosDisponibles[0]['PERMISO_INSERCION'];
    var permisoEliminacion = permisosDisponibles[0]['PERMISO_ELIMINACION'];
    var permisoActualizacion = permisosDisponibles[0]['PERMISO_ACTUALIZACION'];

/*
    if (parseInt(permisoInsercion) === 0) {
        // Deshabilitar el botón si permisoInsercion es igual a cero
        var botonNuevo = document.getElementById('botonNuevo');
        botonNuevo.disabled = true;
    }
*/

    if (parseInt(permisoActualizacion) === 0) {
        // Obtener todos los botones de edición
        var botonesEditar = document.querySelectorAll('[id^="botonEditar_"]');
        
        // Iterar sobre los botones y deshabilitarlos
        botonesEditar.forEach(function(boton) {
            boton.disabled = true;
        });
    }  

    if (parseInt(permisoEliminacion) === 0) {
        var botonesEliminar = document.querySelectorAll('[id^="botonEliminar_"]');
        
        if (botonesEliminar) {
                // Iterar sobre los botones y deshabilitarlos
            botonesEliminar.forEach(function(boton) {
                boton.disabled = true;
            });
        } else {
        // El botón no existe, realizar acciones alternativas o mostrar un mensaje de error
        console.log("El botón 'botonesEliminar' no se encontró en el documento.");
        }        


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
    setupValidation('NOMBRE_CONTACTO', 'error-message-nombre', /[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g);
    // Configuración para el campo de APELLIDO
    setupValidation('APELLIDO_CONTACTO', 'error-message-apellido', /[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g);
     // Configuración para el campo de RELACION
     setupValidation('RELACION', 'error-message-relacion', /[^A-Za-záéíóúÁÉÍÓÚñÑ ]/g);
    // Configuración para el campo de TElEFONO
    setupValidation('TELEFONO', 'error-message-telefono', /[^0-9]/g);
    
</script>
<!-- scripts para generar reportes excel y pdf-->

<script>
        //pdf
        function generarPDF() {
    const printWindow = window.open('', '_blank');
    const tableContent = document.getElementById('miTabla').cloneNode(true);

    // Elimina la última columna que contiene botones de eliminar y editar
    const rows = tableContent.querySelectorAll('tr');
    rows.forEach(row => {
        const lastCell = row.lastElementChild;
        lastCell.parentNode.removeChild(lastCell);
    });

    // Ruta de la imagen local (reemplaza 'TU_RUTA_DE_IMAGEN_LOCAL' con la ruta correcta)
    const imagePath = 'vendor/adminlte/dist/img/axe.png';

    // Convertir la imagen local a base64 de forma asíncrona
    const getBase64ImageAsync = (imgPath, callback) => {
        const img = new Image();
        img.onload = function () {
            const canvas = document.createElement('canvas');
            canvas.width = img.width;
            canvas.height = img.height;

            const ctx = canvas.getContext('2d');
            ctx.drawImage(img, 0, 0);

            const dataURL = canvas.toDataURL('image/png');
            callback(dataURL.replace(/^data:image\/(png|jpg);base64,/, ''));
        };

        img.src = imgPath;
    };

    // Obtener la base64 de la imagen
    getBase64ImageAsync(imagePath, (logoBase64) => {
        printWindow.document.open();
        printWindow.document.write(`
            <html>
            <head>
                <title>Reporte Contactos Emergencia</title>
                <style>
                    table {
                        border-collapse: collapse;
                        width: 100%;
                    }

                    th, td {
                        border: 1px solid black;
                        padding: 8px;
                        text-align: left;
                    }
                </style>
            </head>
            <body>
                <div>
                    <img src="data:image/png;base64, ${logoBase64}" alt="Logo" style="width: 50px; height: 50px; margin: 10px;">
                    <h1 style="text-align: center;">Reportes Contactos Emergencia</h1>
                </div>
                ${tableContent.outerHTML}
            </body>
            </html>
        `);
        printWindow.document.close();

        // Espera a que se cargue el contenido antes de llamar al método print
        printWindow.onload = function () {
            printWindow.print();
            printWindow.onafterprint = function () {
                printWindow.close();
            };
        };
    });
}
    </script>

<script>
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
    saveAs(excelBlob, 'ReporteContactoEmergencia.xlsx');
}

// Función para convertir una cadena binaria en una matriz de bytes
function s2ab(s) {
    const buf = new ArrayBuffer(s.length);
    const view = new Uint8Array(buf);
    for (let i = 0; i !== s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
    return view;
}

</script>
@stop