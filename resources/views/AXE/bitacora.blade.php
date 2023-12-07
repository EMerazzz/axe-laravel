@extends('adminlte::page')

@section('title', 'Bitacoras')

@section('content_header')
<style>
  .custom-blockquote {
    line-height: 0; /* Reducción de la altura */
    margin-top: -5px; 
    margin-bottom:-5px; /* Reducción del espacio inferior del bloquequote */
  }
</style>
<blockquote class="custom-blockquote">
    <p class="mb-0">Bitacora de el sistema AXE.</p>
   
</blockquote>
@stop

@section('content')
<!-- Cambiar Modo
<div class="d-flex justify-content-end align-items-center">
    <button id="mode-toggle" class="btn btn-info ms-2 btn-with-margin">
        <i class="fas fa-adjust"></i> Cambiar Modo
    </button>
</div>--->
<div class="d-flex align-items-center justify-content-center mb-4">
    <!-- Grupo de PDF y Excel -->
    <div class="d-inline-block align-items-center">
        <button id="export-pdf" class="btn btn-danger" onclick="generarPDF()" style="margin-right: 8px;">
            <i class="far fa-file-pdf"></i> Exportar a PDF
        </button>

        <button id="export-excel" class="btn btn-success" onclick="exportToExcel()" style="margin-left: 8px;">
            <i class="far fa-file-excel"></i> Exportar a Excel
        </button>
    </div>
</div>



<style>
        /* Agrega margen derecho al botón */
        .btn-with-margin {
            margin-right: 10px; /* Ajusta el valor según tus necesidades */
            margin-bottom: 20px; /* Ajusta el valor según tus necesidades */
        }
</style>





<form id="myForm" action="{{ url('bitacora/guardar')}}" method="post">
    @csrf
    <input type="hidden" name="miTexto" value="{{ $ESTADO_BITACORA }}"> <!-- Valor recibido del controlador -->

    <!-- Checkbox que refleja el valor recibido -->
    <input type="checkbox" id="checkbox_miTexto" name="checkbox_miTexto" value="1" onchange="submitForm(this)"
    @if ($ESTADO_BITACORA == 1) checked @endif>
    
    <!-- Etiqueta para describir la funcionalidad del checkbox -->
    <label for="checkbox_miTexto"><strong>Habilitar/Deshabilitar Bitácora</strong></label>
</form>


<form id="myForm" action="{{ url('bitacora/limpiar')}}" method="post">
    @csrf
    <button type="submit" class="btn btn-primary">Limpiar bitacora</button>
</form>




<div class="table-responsive">

<table id="miTabla" class="table table-hover table-light table-striped mt-1" style="border:2px solid lime;">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre Tabla</th>
                <th>Módulo tabla</th>
                <th>Fecha Modificación</th>
                <th>Tipo evento</th>
                <th>Fecha Registro</th>
                <th>Usuario Modificador</th>
                <th>Código Tabla</th>
                <th>Primera FK</th>
                <th>Segunda FK</th>
                <th>Tercera FK</th>
                <th>Campo viejo 1</th>
                <th>Campo viejo 2</th>
                <th>Campo viejo 3</th>
                <th>Campo viejo 4</th>
                <th>Campo viejo 5</th>
                <th>Campo viejo 6</th>
                <th>Campo viejo 7</th>
                <th>Campo viejo 8</th>
                <th>Campo viejo 9</th>
                <th>Campo nuevo 10</th>
                <th>Campo nuevo 11</th>
                <th>Campo nuevo 12</th>
                <th>Campo nuevo 13</th>
                <th>Campo nuevo 14</th>
                <th>Campo nuevo 15</th>
                <th>Campo nuevo 16</th>
                <th>Campo nuevo 17</th>
                <th>Campo nuevo 18</th>

            </tr>
        </thead>
        <tbody>
            @foreach($bitacoraArreglo as $bitacora)
           
            <tr>
                <td>{{ $bitacora['COD_BITACORA'] }}</td>
                <td>{{ $bitacora['NOMBRE_TABLA'] }}</td>
                <td>{{ $bitacora['MODULO_TABLA'] }}</td>
                <td>{{ date('d, M Y', strtotime($bitacora['FECHA_MODIFICACION'])) }}</td>
                <td>{{ $bitacora['TIPO_EVENTO'] }}</td>
                <td>{{ date('Y-m-d', strtotime($bitacora['FECHA_REGISTRO'])) }}</td>
                <td>{{ $bitacora['USUARIO'] }}</td>
                <td>{{ $bitacora['COD_REGISTRO_TABLA'] }}</td>
                <td>{{ $bitacora['PRIMERA_FK'] }}</td>
                <td>{{ $bitacora['SEGUNDA_FK'] }}</td>
                <td>{{ $bitacora['TERCERA_FK'] }}</td>
                <td>{{ $bitacora['CAMPO1_VIEJO'] }}</td>
                <td>{{ $bitacora['CAMPO2_VIEJO'] }}</td>
                <td>{{ $bitacora['CAMPO3_VIEJO'] }}</td>
                <td>{{ $bitacora['CAMPO4_VIEJO'] }}</td>
                <td>{{ $bitacora['CAMPO5_VIEJO'] }}</td>
                <td>{{ $bitacora['CAMPO6_VIEJO'] }}</td>
                <td>{{ $bitacora['CAMPO7_VIEJO'] }}</td>
                <td>{{ $bitacora['CAMPO8_VIEJO'] }}</td>
                <td>{{ $bitacora['CAMPO9_VIEJO'] }}</td>
                <td>{{ $bitacora['CAMPO10_NUEVO'] }}</td>
                <td>{{ $bitacora['CAMPO11_NUEVO'] }}</td>
                <td>{{ $bitacora['CAMPO12_NUEVO'] }}</td>
                <td>{{ $bitacora['CAMPO13_NUEVO'] }}</td>
                <td>{{ $bitacora['CAMPO14_NUEVO'] }}</td>
                <td>{{ $bitacora['CAMPO15_NUEVO'] }}</td>
                <td>{{ $bitacora['CAMPO16_NUEVO'] }}</td>
                <td>{{ $bitacora['CAMPO17_NUEVO'] }}</td>
                <td>{{ $bitacora['CAMPO18_NUEVO'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>




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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
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
    function submitForm(checkbox) {
        if (checkbox.checked) {
            checkbox.previousElementSibling.value = '1'; // Establece el valor del campo oculto en 1 si el checkbox está marcado
        } else {
            checkbox.previousElementSibling.value = '0'; // Establece el valor del campo oculto en 0 si el checkbox no está marcado
        }
        document.getElementById('myForm').submit(); // Envía el formulario
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



<script >
$(document).ready(function() {
    function setCheckboxState() {
        var estadoBitacora = "{{ $ESTADO_BITACORA }}";
        console.log("Estado de la bitácora:", estadoBitacora);

        if (estadoBitacora == 1) {
            $('#checkbox_miTexto').prop('checked', true);
        } else {
            $('#checkbox_miTexto').prop('checked', false);
        }
    }

    setCheckboxState(); 
});
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
                <title>Reporte Bitácoras</title>
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
                    <h1 style="text-align: center;">Reportes Bitácoras</h1>
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
    saveAs(excelBlob, 'ReporteBitacora.xlsx');
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