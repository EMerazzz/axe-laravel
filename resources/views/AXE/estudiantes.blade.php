@extends('adminlte::page')

@section('title', 'Estudiantes')

@section('content_header')
<style>
  .custom-blockquote {
    line-height: 0;
    margin-top: -5px;
    margin-bottom: -5px;
  }
</style>
<blockquote class="custom-blockquote">
    <p class="mb-0">Estudiantes registrados en el sistema AXE.</p>
</blockquote>
@stop

@section('content')
<div class="container">
    <div class="d-flex align-items-center mb-4">
        <div class="d-inline-block align-items-center">
            <button class="btn btn-danger" onclick="generarlista()" style="margin-right: 8px;">
                <i class="far fa-file-pdf"></i> generar lista
            </button>
        </div>
        <div class="d-inline-block align-items-center">
        <button class="btn btn-danger" onclick="generarPDF()" style="margin-right: 8px;">
    <i class="far fa-file-pdf"></i> Exportar a PDF
</button>
        </div>
        <div class="d-inline-block align-items-center">
            <button class="btn btn-success" onclick="exportToExcel()" style="margin-left: 8px;">
                <i class="far fa-file-excel"></i> Exportar a Excel
            </button>
        </div>
    </div>
</div>


<div class="table-responsive">
    <table id="miTabla" class="table table-hover table-light table-striped mt-1" style="border:2px solid lime;">
        <thead>
            <tr>
                <th>Estudiante</th>
                <th>Nivel Académico</th> 
                <th>Año Académico</th>
                <th>Sección</th>
                <th>Jornada</th>
                <th>Año matricula</th>
            </tr>
        </thead>
        <tbody>
            @foreach($matriculaArreglo as $matricula)
            <tr>
                <td>{{ $matricula['NOMBRE'] . ' ' . $matricula['APELLIDO'] }}</td>
                <td>{{ $matricula['NIVEL'] }}</td> 
                <td>{{ $matricula['GRADO'] }}</td>
                <td>{{ $matricula['SECCION'] }}</td>
                <td>{{ $matricula['JORNADA'] }}</td>
                <td>{{ $matricula['AÑO_MATRICULA'] }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@stop

@section('footer')
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
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.default.min.css">
@stop

@section('js')
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.2/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

    <script>
    $(document).ready(function() {
        var table = $('#miTabla').DataTable({
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
            "lengthMenu": [5, 10, 30, 50, 100, 200],
            "pageLength": 5,
            "order": [[0, 'desc']]
        });

        $('#miTabla thead th').each(function() {
            var title = $(this).text();
            $(this).html('<select class="filtroColumna"><option value="">' + title + '</option></select>');
        });

        table.columns().every(function() {
            var column = this;
            var select = $(this.header()).find('select');

            if (select.hasClass('filtroColumna')) {
                column.data().unique().sort().each(function(d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>');
                });
            }

            select.on('change', function() {
                var val = $.fn.dataTable.util.escapeRegex($(this).val());
                column.search(val ? '^' + val + '$' : '', true, false).draw();
            });
        });
    });
    </script>

    <script>
    const modeToggle = document.getElementById('mode-toggle');
    const body = document.body;
    const table = document.getElementById('miTabla');
    const modals = document.querySelectorAll('.modal-content');

    const storedTheme = localStorage.getItem('theme');
    if (storedTheme) {
        body.classList.add(storedTheme);
        table.classList.toggle('table-dark', storedTheme === 'dark-mode');
        modals.forEach(modal => {
            modal.classList.toggle('dark-mode', storedTheme === 'dark-mode');
        });
    }

    modeToggle.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        table.classList.toggle('table-dark');

        modals.forEach(modal => {
            modal.classList.toggle('dark-mode');
        });

        const theme = body.classList.contains('dark-mode') ? 'dark-mode' : '';
        localStorage.setItem('theme', theme);
    });
    </script>

    <script>
    $(document).ready(function() {
        $('.selectize').selectize({
            placeholder: 'Seleccione',
            allowClear: true,
            searchField: ['text', 'IDENTIDAD'],
        });
    });
    </script>


<script>
function generarlista() {
    const tableData = [];
    const headerData = [];

    // Agrega el encabezado "Estudiantes" a la primera columna
    headerData.push({ text: 'Estudiantes', bold: true });

    // Agrega otras columnas al encabezado
    const otherColumnNames = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "OBS"];
    otherColumnNames.forEach(columnName => {
        headerData.push({ text: columnName, bold: true });
    });

    // Obtén todos los datos de la tabla, incluyendo solo las filas visibles después del filtrado
    const table = $('#miTabla').DataTable();
    const filteredData = table.rows({ search: 'applied' }).data();

    filteredData.each(function (rowData) {
        const row = [{ text: rowData[0], bold: true }]; // Poner en negrita el dato real de la primera columna

        // Agrega datos de otras columnas al row, dejándolos en blanco si no es la primera columna
        for (let i = 1; i <= 6; i++) {
            row.push({ text: i === 0 ? rowData[i] : '', bold: i === 1 }); // Poner en negrita solo la primera columna
        }

        // Asegúrate de que la cantidad de celdas en la fila coincida con la cantidad de elementos en headerData
        if (row.length === headerData.length) {
            tableData.push(row);
        }
    });

    const documentDefinition = {
        pageOrientation: 'landscape',
        content: [
            {
                text: 'Lista de asistencia',
                fontSize: 16,
                bold: true,
                alignment: 'center',
                margin: [0, 0, 0, 10]
            },
            {
                table: {
                    headerRows: 1,
                    widths: [200, 80, 80, 80, 80, 80, 100], // Ajusta estos valores según tus necesidades
                    body: [
                        headerData,
                        ...tableData
                    ],
                    style: {
                        lineHeight: 1.2 // Ajusta este valor para cambiar el tamaño de las celdas
                    }
                }
            }
        ]
    };

    pdfMake.createPdf(documentDefinition).download('Lista de asistencia.pdf');
}

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
                <title>Reporte Estudiantes</title>
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
                    <h1 style="text-align: center;">Reportes Estudiantes</h1>
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

        const tableHeader = document.querySelectorAll('#miTabla thead th');
        tableHeader.forEach(headerCell => {
            if (headerCell.textContent !== 'Opciones de la Tabla') {
                headerData.push(headerCell.textContent);
            }
        });

        const table = $('#miTabla').DataTable();
        const allData = table.rows().data();

        allData.each(function (rowData) {
            const row = [];
            rowData.forEach((cell, index) => {
                if (index !== rowData.length - 1) {
                    row.push(cell);
                }
            });
            tableData.push(row);
        });

        const worksheetData = [headerData, ...tableData];

        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.aoa_to_sheet(worksheetData);

        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');

        const excelBinary = XLSX.write(wb, { bookType: 'xlsx', type: 'binary' });
        const excelBlob = new Blob([s2ab(excelBinary)], {
            type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        });

        saveAs(excelBlob, 'ReporteEstudiantes.xlsx');
    }

    function s2ab(s) {
        const buf = new ArrayBuffer(s.length);
        const view = new Uint8Array(buf);
        for (let i = 0; i !== s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
        return view;
    }
    </script>
@stop
