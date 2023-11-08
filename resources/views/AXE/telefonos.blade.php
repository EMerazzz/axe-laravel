@extends('adminlte::page')

@section('title', 'Teléfonos')

@section('content_header')
<style>
  .custom-blockquote {
    line-height: 0; /* Reducción de la altura */
    margin-top: -5px; 
    margin-bottom:-5px; /* Reducción del espacio inferior del bloquequote */
  }
</style>
<blockquote class="custom-blockquote">
    <p class="mb-0">Teléfonos registrados en el sistema AXE.</p>
</blockquote>

@stop
 
@section('content')
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
<button type="button" class="btn btn-success btn-custom" data-toggle="modal" data-target="#personas">+ Nuevo</button>
<div class="spacer"></div>
<div class="modal fade bd-example-modal-sm" id="personas" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ingresa Nuevo Teléfono</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{ url('telefonos/insertar') }}" method="post">
                        @csrf
                        <!-- INICIO --->
                        <div class="mb-3 mt-3">
                            <label for="COD_PERSONA" class="form-label">Persona: </label>
                            <select class="selectize" id="COD_PERSONA" name="COD_PERSONA" required>
                                <option value="" disabled selected>Seleccione una persona</option>
                                @foreach ($personasArreglo as $persona)
                                    <option value="{{ $persona['COD_PERSONA'] }}">{{ $persona['NOMBRE'] }} {{ $persona['APELLIDO'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <!-- FIN --->
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
                <th>Número Teléfono</th>
                <th>Tipo Teléfono</th>
                <th>Fecha Registro</th>
                <th>Opciones Tabla</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($telefonosArreglo as $telefonos)
                @php
                    $persona = null;
                    foreach ($personasArreglo as $p) {
                        if ($p['COD_PERSONA'] === $telefonos['COD_PERSONA']) {
                            $persona = $p;
                            break;
                        }
                    }
                @endphp
                <tr>
                    <td>{{ $telefonos['COD_TELEFONO'] }}</td>
                    <td>
                        @if ($persona !== null)
                            {{ $persona['NOMBRE'] . ' ' . $persona['APELLIDO'] }}
                        @else
                            Persona no encontrada
                        @endif
                    </td>
                    <td>{{ $telefonos['TELEFONO'] }}</td>
                    <td>{{ $telefonos['TIPO_TELEFONO'] }}</td>
                    <td>{{ date('d, M Y', strtotime($telefonos['FECHA'])) }}</td>
                    <td>
                        <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal"
                            data-target="#telefonos-edit-{{ $telefonos['COD_TELEFONO'] }}">
                            <i class="fas fa-edit" style="font-size: 13px; color: cyan;"></i> Editar
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>



@foreach($telefonosArreglo as $telefonos)
<div class="modal fade bd-example-modal-sm" id="telefonos-edit-{{ $telefonos['COD_TELEFONO'] }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualiza Teléfono</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{ url('telefonos/actualizar') }}" method="post">
                        @csrf
                        <input type="hidden" class="form-control" name="COD_TELEFONO" value="{{ $telefonos['COD_TELEFONO'] }}">
                        <div class="mb-3 mt-3">
                            <label for="COD_PERSONA" class="form-label">Persona:</label>
                            <select class="selectize" id="COD_PERSONA" name="COD_PERSONA" required>
                                @foreach ($personasArreglo as $persona)
                                    <option value="{{ $persona['COD_PERSONA'] }}" {{ $persona['COD_PERSONA'] == $telefonos['COD_PERSONA'] ? 'selected' : '' }}>
                                        {{ $persona['NOMBRE'] }} {{ $persona['APELLIDO'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3 mt-3">
                            <label for="TELEFONO" class="form-label">Número Teléfono:</label>
                            <input type="text" class="form-control" id="TELEFONO" name="TELEFONO" placeholder="____-____" oninput="formatTelefono(this)" pattern="[0-9]{8}" value="{{$telefonos['TELEFONO']}}"  required>
                        </div>

                        <div class="mb-3">
                            <label for="TIPO_TELEFONO" class="form-label">Tipo Telefono:</label>
                            <select class="form-control same-width" id="TIPO_TELEFONO" name="TIPO_TELEFONO">
                                <option value="Fijo" {{ $telefonos['TIPO_TELEFONO'] === 'Fijo' ? 'selected' : '' }}>Fijo</option>
                                <option value="Movil" {{ $telefonos['TIPO_TELEFONO'] === 'Movil' ? 'selected' : '' }}>Movil</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Editar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.5/jquery.inputmask.min.js"></script>
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
    <!-- Script personalizado para validaciones -->
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


    // Configuración para el campo de IDENTIDAD
    setupValidation('TELEFONO', 'error-message-telefono', /[^0-9]/g);
    
</script>
   <!-- Script personalizado para CAMBIAR MODO -->
<script>
   const modeToggle = document.getElementById('mode-toggle');
const body = document.body;
const table = document.getElementById('miTabla');

modeToggle.addEventListener('click', () => {
    body.classList.toggle('dark-mode');
    table.classList.toggle('table-dark'); 
});
</script>
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