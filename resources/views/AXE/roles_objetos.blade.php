@extends('adminlte::page')

@section('title', 'Roles Objetos')

@section('content_header')
<style>
  .custom-blockquote {
    line-height: 0; /* Reducción de la altura */
    margin-top: -5px; 
    margin-bottom:-5px; /* Reducción del espacio inferior del bloquequote */
  }
</style>
<blockquote class="custom-blockquote">
    <p class="mb-0">Roles Objetos registrados en el sistema AXE.</p>
</blockquote>
@stop

@section('content')
<!-- Agregar botones de Exportar
<div class="d-flex justify-content-end align-items-center">
    <button id="mode-toggle" class="btn btn-info ms-2" style="margin-top: 10px; margin-bottom: -60px;">
        <i class="fas fa-adjust"></i> Cambiar Modo
    </button>
</div>
<div class="d-flex justify-content-center align-items-center mt-3">
<button id="export-pdf" class="btn btn-danger ms-2">
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
<button id="botonNuevo" type="button" class="btn btn-success btn-custom" data-toggle="modal" data-target="#roles_objetos">+ Nuevo</button>
<div class="spacer"></div>
<div class="modal fade bd-example-modal-sm" id="roles_objetos" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ingresa Nuevo Rol Objeto</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>   
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{ url('roles_objetos/insertar') }}" method="post">
                        @csrf
                        <!-- INICIO --->
                        <div class="mb-3 mt-3">
                            <label for="COD_ROL" class="form-label">Rol: </label>
                            <select class="selectize" id="COD_ROL" name="COD_ROL" required>
                                <option value="" disabled selected>Seleccione el rol</option>
                                @foreach ($rolesArreglo as $roles)
                                    <option value="{{ $roles['COD_ROL'] }}">{{ $roles['DESCRIPCION'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- FIN --->
                        <label for="COD_OBJETO" class="form-label">Objeto: </label>
                            <select class="selectize" id="COD_OBJETO" name="COD_OBJETO" required>
                                <option value="" disabled selected>Seleccione el objeto</option>
                                @foreach ($objetosArreglo as $objetos)
                                    <option value="{{ $objetos['COD_OBJETO'] }}">{{ $objetos['OBJETO'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-row">
              <div class="form-group col-md-3">
                <div class="form-check">
                   <input class="form-check-input" type="checkbox" id="PERMISO_INSERCION" name="PERMISO_INSERCION" value="1">
                   <label class="form-check-label" for="PERMISO_INSERCION">Permiso Insertar</label>
                 </div>
              </div>

               <div class="form-group col-md-3">
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" id="PERMISO_ELIMINACION" name="PERMISO_ELIMINACION" value="1" onchange="submitForm(this)>
                   <label class="form-check-label" for="PERMISO_ELIMINACION">Permiso Eliminar</label>
                 </div>
              </div>

                <div class="form-group col-md-3">
                    <div class="form-check">
                     <input class="form-check-input" type="checkbox" id="PERMISO_ACTUALIZACION" name="PERMISO_ACTUALIZACION" value="1" onchange="submitForm(this)>
                     <label class="form-check-label" for="PERMISO_ACTUALIZACION">Permiso Actualizar</label>
                    </div>
                </div>
    
                <div class="form-group col-md-3">
                    <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="PERMISO_CONSULTAR" name="PERMISO_CONSULTAR" value="1" onchange="submitForm(this)>
                    <label class="form-check-label" for="PERMISO_CONSULTAR">Permiso Consultar</label>
                    </div>
                    </div>
                </div>

                
                        <button type="submit" class="btn btn-primary">Añadir</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<table id="miTabla" class="table table-hover table-light table-striped mt-1" style="border:2px solid lime;">
        <thead>
            <tr>
                <th>#</th>
                <th>Rol</th>
                <th>Objeto</th>
                <th>Permiso Insertar</th>
                <th>Permiso Eliminar</th>
                <th>Permiso Actualizar</th>
                <th>Permiso Consultar</th>
                <th>Opciones Tabla</th>
            </tr>
        </thead>
        <tbody>
            @foreach($roles_objetos_Arreglo as $roles_objetos)
            @php
                    $rol = null;
                    foreach ($rolesArreglo as $r) {
                        if ($r['COD_ROL'] === $roles_objetos['COD_ROL']) {
                            $rol = $r;
                            break;
                        }
                    }
                @endphp
                @php
                    $objeto = null;
                    foreach ($objetosArreglo as $o) {
                        if ($o['COD_OBJETO'] === $roles_objetos['COD_OBJETO']) {
                            $objeto = $o;
                            break;
                        }
                    }
                @endphp
            <tr>
                <td>{{ $roles_objetos['COD_ROL_OBJETO'] }}</td>
                <td>
                        @if ($rol !== null)
                            {{ $rol['DESCRIPCION'] }}
                        @else
                            Rol no encontrado
                        @endif
                    </td>
                    <td>
                        @if ($objeto !== null)
                            {{ $objeto['OBJETO'] }}
                        @else
                            Objeto no encontrado
                        @endif
                    </td>
                <td>
                    @if($roles_objetos['PERMISO_INSERCION'] == 1)
                        Permitido
                    @elseif($roles_objetos['PERMISO_INSERCION'] == 0)
                        No Permitido
                    @endif
                 </td>
                <td>
                    @if($roles_objetos['PERMISO_ELIMINACION'] == 1)
                        Permitido
                    @elseif($roles_objetos['PERMISO_ELIMINACION'] == 0)
                        No Permitido
                    @endif
                 </td>
                <td>
                    @if($roles_objetos['PERMISO_ACTUALIZACION'] == 1)
                        Permitido
                    @elseif($roles_objetos['PERMISO_ACTUALIZACION'] == 0)
                        No Permitido
                    @endif
                 </td>
                <td>
                    @if($roles_objetos['PERMISO_CONSULTAR'] == 1)
                        Permitido
                    @elseif($roles_objetos['PERMISO_CONSULTAR'] == 0)
                        No Permitido
                    @endif
                 </td>
                <td>
                    <button id="botonEditar_1" value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal"
                        data-target="#roles_objetos-edit-{{ $roles_objetos['COD_ROL_OBJETO'] }}">
                        <i class="fas fa-edit" style="font-size: 13px; color: cyan;"></i> Editar
                    </button>
                    <!-- boton eliminar-->
                    <button id="botonEliminar_1" value="editar" title="Eliminar" class="btn btn-outline-danger" type="button" data-toggle="modal"
                     data-target="#roles_objetos-delete-{{$roles_objetos['COD_ROL_OBJETO']}}">
                     <i class='fas fa-trash-alt' style='font-size:13px;color:danger'></i> Eliminar
                    </button>
                     <!-- boton eliminar-->
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@foreach($roles_objetos_Arreglo as $roles_objetos)
<div class="modal fade bd-example-modal-sm" id="roles_objetos-edit-{{ $roles_objetos['COD_ROL_OBJETO'] }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualiza Rol Objeto</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{ url('roles_objetos/actualizar') }}" method="post">
                        @csrf
                        <input type="hidden" class="form-control" name="COD_ROL_OBJETO" value="{{ $roles_objetos['COD_ROL_OBJETO'] }}">
                        <div class="mb-3 mt-3">
                            <label for="COD_ROL" class="form-label">Rol:</label>
                            <select class="selectize" id="COD_ROL" name="COD_ROL" required>
                                @foreach ($rolesArreglo as $roles)
                                    <option value="{{ $roles['COD_ROL'] }}" {{ $roles['COD_ROL'] == $roles_objetos['COD_ROL'] ? 'selected' : '' }}>
                                        {{ $roles['DESCRIPCION'] }} 
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="COD_OBJETO" class="form-label">Objeto:</label>
                            <select class="selectize" id="COD_OBJETO" name="COD_OBJETO" required>
                                @foreach ($objetosArreglo as $objetos)
                                    <option value="{{ $objetos['COD_OBJETO'] }}" {{ $objetos['COD_OBJETO'] == $roles_objetos['COD_OBJETO'] ? 'selected' : '' }}>
                                        {{ $objetos['OBJETO'] }} 
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <input type="checkbox" id="PERMISO_INSERCION" name="PERMISO_INSERCION" value="1" {{ $roles_objetos['PERMISO_INSERCION'] === '1' ? 'checked' : '' }}>
                            <label for="PERMISO_INSERCION">Permiso Insertar</label>
                            </div>
                             
                            <div>
                            <input type="checkbox" id="PERMISO_ELIMINACIONn" name="PERMISO_ELIMINACION" value="1" {{ $roles_objetos['PERMISO_ELIMINACION'] === '1' ? 'checked' : '' }}>
                            <label for="PERMISO_ELIMINACION">Permiso Eliminar</label>
                             </div>

                            <div>
                            <input type="checkbox" id="PERMISO_ACTUALIZACION" name="PERMISO_ACTUALIZACION" value="1" {{ $roles_objetos['PERMISO_ACTUALIZACION'] === '1' ? 'checked' : '' }}>
                            <label for="PERMISO_ACTUALIZACION">Permiso Actualizar</label>
                            </div>

                             <div>
                            <input type="checkbox" id="PERMISO_CONSULTAR" name="PERMISO_CONSULTAR" value="1" {{ $roles_objetos['PERMISO_CONSULTAR'] === '1' ? 'checked' : '' }}>
                            <label for="PERMISO_CONSULTAR">Permiso Consultar</label>
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
<div class="modal fade bd-example-modal-sm" id="roles_objetos-delete-{{$roles_objetos['COD_ROL_OBJETO']}}" tabindex="-1">
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
      <form action="{{ url('roles_objetos/delete') }}" method="post">
                        @csrf
      <input type="hidden" class="form-control" name="COD_ROL_OBJETO" value="{{ $roles_objetos['COD_ROL_OBJETO'] }}">
              <button  class="btn btn-danger">Si</button>
          </form>
        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
        
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
    function submitForm(checkbox) {
        var hiddenInput = document.getElementById('permisoHidden');
        hiddenInput.value = checkbox.checked ? '1' : '0';
        document.getElementById('myForm').submit();
    }
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

 <!-- Script personalizado para validaciones -->
 <script>
    function setupValidation(inputId, errorMessageId, pattern) {
        const input = document.getElementById(inputId);
        const errorMessage = document.getElementById(errorMessageId);

        input.addEventListener('input', function() {
            const inputValue = input.value.replace(pattern, ''); // Remueve caracteres no permitidos

            if (inputValue !== input.value) {
                input.value = inputValue;
                errorMessage.style.display = 'block';
            } else {
                errorMessage.style.display = 'none';
            }
        });

        // Llamada inicial para aplicar la validación cuando se cargue la página
        input.dispatchEvent(new Event('input'));
    }

    // Configuración para el campo de CORREO_ELECTRONICO
    setupValidation('CORREO_ELECTRONICO', 'error-message-correo', /\s/g); // Evita espacios en blanco
</script>
<!-- scripts para generar reportes excel y pdf-->
<!-- scripts para generar reportes excel y pdf-->

<script>
        document.getElementById('export-pdf').addEventListener('click', function () {
            const tableHeader = Array.from(document.querySelectorAll('#miTabla thead th')).map(th => th.textContent);
            const tableData = [];
            const tableRows = document.querySelectorAll('#miTabla tbody tr');
            
            tableRows.forEach(row => {
                const rowData = Array.from(row.querySelectorAll('td')).map(cell => cell.textContent);
                tableData.push(rowData);
            });

            const documentDefinition = {
                pageOrientation: 'landscape', // Establece la orientación de la página a horizontal
                content: [
                    { text: 'Reporte de Tabla en PDF', fontSize: 16, bold: true, alignment: 'center', margin: [0, 0, 0, 10] },
                    {
                        table: {
                            headerRows: 1,
                            widths: Array(tableHeader.length).fill('*'),
                            body: [
                                tableHeader, // Encabezado de la tabla
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
        });
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
    function submitForm(checkbox) {
        if (checkbox.checked) {
            checkbox.previousElementSibling.value = '1'; // Establece el valor del campo oculto en 1 si el checkbox está marcado
        } else {
            checkbox.previousElementSibling.value = '0'; // Establece el valor del campo oculto en 0 si el checkbox no está marcado
        }
        document.getElementById('myForm').submit(); // Envía el formulario
    }
</script>


@stop