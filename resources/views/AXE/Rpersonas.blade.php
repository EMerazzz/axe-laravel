@extends('adminlte::page')

@section('title', 'Reportes personas')

@section('content_header')
<style>
  .custom-blockquote {
    line-height: 0; /* Reducción de la altura */
    margin-top: -5px; 
    margin-bottom:-5px; /* Reducción del espacio inferior del bloquequote */
  }
</style>
<blockquote class="custom-blockquote">
    <p class="mb-0"><strong>Reportes Personas</strong></p>
    
   
</blockquote>
@stop

@section('content')
<!-- Cambiar Modo
<div class="d-flex justify-content-end align-items-center">
    <button id="mode-toggle" class="btn btn-info ms-2 btn-with-margin">
        <i class="fas fa-adjust"></i> Cambiar Modo
    </button>
</div>--->

<div class="d-inline-block align-items-center mt-2">
    <!-- Grupo de PDF -->
    <label for="start-date">Inicio:</label>
    <input type="date" id="start-date" class="me-1">
    <label for="end-date">Fin:</label>
    <input type="date" id="end-date" class="me-1">
    <button id="apply-filter" class="btn btn-danger me-1">
        <i class="far fa-file-pdf"></i> Descargar PDF
    </button>
</div>

<div class="d-inline-block align-items-center mt-2">
    <!-- Grupo de Excel -->
    <button id="export-excel" class="btn btn-success ms-2" onclick="exportToExcel()">
        <i class="far fa-file-excel"></i> Exportar a Excel
    </button>
</div>



<div class="table-responsive">
<table id="miTabla" class="table table-hover table-light table-striped mt-1" style="border:2px solid lime;">
        <thead>
            <tr>
            <th>#</th> 
        <th>Nombres</th> 
        <th>Apellidos</th>
        <th>Número Identidad</th>
        <th>Género</th>
        <th>Tipo Persona</th>
        <th>Fecha Nacimiento</th>
        <th>Edad</th>
        <th>Fecha Registro</th>

            </tr>
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
            <td>{{date('Y-m-d', strtotime($personas['FECHA_REGISTRO']))}}</td>
            
            </tr>
            @endforeach
        </tbody>
    </table>
</div>




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
 <!--           *****     *****      Script genera pdf  *****       *****                     -->


<script>
$(document).ready(function() {
    const table = $('#miTabla').DataTable({
         
            
        paging: false // Desactivar la paginación
    });

    function applyDateRangeFilter() {
        const startDate = $('#start-date').val();
        const endDate = $('#end-date').val();

        table.columns().every(function() {
            const columnIndex = this.index();

            if (columnIndex === 8) { // Índice de la columna "Fecha de registro"
                const column = this;
                const formattedStartDate = new Date(startDate).toISOString().split('T')[0];
                const formattedEndDate = new Date(endDate).toISOString().split('T')[0];

                column.data().each(function(value, index) {
                    const dateValue = new Date(value).toISOString().split('T')[0];
                    const row = table.row(index).nodes().to$();

                    if (dateValue >= formattedStartDate && dateValue <= formattedEndDate) {
                        row.show();
                    } else {
                        row.hide();
                    }
                });
            }
        });
    }

    $('#apply-filter').on('click', function() {
        applyDateRangeFilter();
        const filteredData = gatherFilteredData(); // Obtener los datos filtrados
        generarPDF(filteredData); // Llamar a la función generarPDF después de aplicar el filtro
    });

    function gatherFilteredData() {
    const filteredData = [];

    // Iterar sobre las filas visibles de la tabla después de aplicar el filtro
    $('#miTabla tbody tr:visible').each(function() {
        const rowData = [];
        $(this).find('td').each(function() {
            rowData.push($(this).text());
        });
        filteredData.push(rowData);
    });

    return filteredData;
}

function generarPDF(filteredData) {
    const tableData = [];
    const headerData = [];

    // Obtén los encabezados de la tabla
    const tableHeader = document.querySelectorAll('#miTabla thead th');
    tableHeader.forEach(headerCell => {
        headerData.push({ text: headerCell.textContent, bold: true });
    });

    // Usar los datos filtrados directamente
    filteredData.forEach(rowData => {
        const row = [];
        rowData.forEach(cell => {
            row.push(cell);
        });
        tableData.push(row);
    });

    const documentDefinition = {
        pageSize: 'legal', // Tamaño de página
        pageOrientation: 'landscape',
        content: [
            {
                text: 'Reporte Personas en pdf ',
                fontSize: 16,
                bold: true,
                alignment: 'center',
                margin: [-10, 0, 0, 10]
            },
            {
                table: {
                    headerRows: 1,
                    widths: '*',
                    body: [
                        headerData,
                        ...tableData
                    ],
                    style: {
                        lineHeight: 1.2
                    }
                }
            }
        ]
    };

    // Pregunta al usuario si desea imprimir o descargar el PDF
    const shouldPrint = confirm('¿Desea imprimir el PDF? Si no, se descargará automáticamente.');
    if (shouldPrint) {
        pdfMake.createPdf(documentDefinition).print();
    } else {
        pdfMake.createPdf(documentDefinition).download('ReportePersonas.pdf');
    }
}

// Llamar a la función con los datos filtrados
// Puedes obtener los datos filtrados de la manera que prefieras
// Por ejemplo, usando DataTables: const filteredData = gatherFilteredData();
// generarPDF(filteredData);


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
    saveAs(excelBlob, 'ReportePersonas.xlsx');
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