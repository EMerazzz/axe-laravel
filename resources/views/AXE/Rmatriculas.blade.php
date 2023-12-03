@extends('adminlte::page')

@section('title', 'Reportes matricula')

@section('content_header')
<style>
  .custom-blockquote {
    line-height: 0; /* Reducción de la altura */
    margin-top: -5px; 
    margin-bottom:-5px; /* Reducción del espacio inferior del bloquequote */
  }
</style>
<blockquote class="custom-blockquote">
    <p class="mb-0"><strong>Reportes Matrícula.</strong></p>
   
</blockquote>
@stop

@section('content')
<!-- Cambiar Modo
<div class="d-flex justify-content-end align-items-center">
    <button id="mode-toggle" class="btn btn-info ms-2 btn-with-margin">
        <i class="fas fa-adjust"></i> Cambiar Modo
    </button>
</div>--->

<div class="d-flex align-items-center mb-4">
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


<div class="table-responsive">
<table id="miTabla" class="table table-hover table-light table-striped mt-1" style="border:2px solid lime;">
<thead>
            <tr>
                <th>#</th>
                <th>Estudiante</th>
                <th>Nivel Académico</th>
                <th>Año Académico</th>
                <th>Sección</th>
                <th>Jornada</th>
                <th>Estado Matrícula</th>
                <th>Fecha Matrícula </th>
                <th>Encargado </th>
               
            </tr>
        </thead>
        <tbody>
            @foreach($matriculaArreglo as $matricula)
            
            @php
                    $persona = null;
                    foreach ($personasArreglo as $p) {
                        if ($p['COD_PERSONA'] === $matricula['COD_PERSONA']) {
                            $persona = $p;
                            break;
                        }
                    }
                @endphp
                @php
                    $nivel_academico = null;
                    foreach ($nivel_academicoArreglo as $n) {
                        if ($n['COD_NIVEL_ACADEMICO'] === $matricula['COD_NIVEL_ACADEMICO']) {
                            $nivel_academico = $n;
                            break;
                        }
                    }
                @endphp

                @php
                    $anio_academico = null;
                    foreach ($anio_academicoArreglo as $a) {
                        if ($a['COD_ANIO_ACADEMICO'] === $matricula['COD_ANIO_ACADEMICO']) {
                            $anio_academico = $a;
                            break;
                        }
                    }
                @endphp
                @php
                    $padres = null;
                    foreach ($padresArreglo as $p) {
                        if ($p['COD_PADRE_TUTOR'] === $matricula['COD_PADRE_TUTOR']) {
                            $padres = $p;
                            break;
                        }
                    }
                @endphp
            <tr>
                <td>{{ $matricula['COD_MATRICULA'] }}</td>
                <td>
                        @if ($persona !== null)
                            {{ $persona['NOMBRE']. ' ' . $persona['APELLIDO'] }}
                        @else
                            Persona no encontrada
                        @endif
                </td>
                 <td>
                        @if ($nivel_academico !== null)
                            {{ $nivel_academico['descripcion']}}
                        @else
                             no encontrado
                        @endif
                 </td>
                 <td>
                        @if ($anio_academico !== null)
                            {{ $anio_academico['descripcion']}}
                        @else
                             no encontrado
                        @endif
                 </td>
                 <td>{{ $matricula['SECCION'] }}</td>
                 <td>{{ $matricula['JORNADA'] }}</td>
                 <td>{{ $matricula['ESTADO_MATRICULA'] }}</td>
                 <td>{{date('d, M Y', strtotime($matricula['FECHA_MATRICULA']))}}</td>
                 <td>
                        @if ($padres !== null)
                            {{ $padres['NOMBRE_PADRE_TUTOR']. ' ' .$padres['APELLIDO_PADRE_TUTOR']}}
                        @else
                             no encontrado
                        @endif
                 </td>
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

            if (columnIndex === 7) { // Índice de la columna "Fecha de registro"
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
</script>


</script>


<script>
//pdf
function generarPDF() {
    const printWindow = window.open('', '_blank');
    const tableContent = document.getElementById('miTabla').outerHTML;

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
                <title>Reporte Matrícula</title>
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
                    <h1 style="text-align: center;">Reportes Matrícula</h1>
                </div>
                ${tableContent}
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





@stop