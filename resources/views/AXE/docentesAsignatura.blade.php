@extends('adminlte::page')

@section('title', 'Asignatura docentes')
@section('content_header')
<style>
  .custom-blockquote {
    line-height: 0; /* Reducción de la altura */
    margin-top: -5px; 
    margin-bottom:-5px; /* Reducción del espacio inferior del bloquequote */
  }
</style>
<blockquote class="custom-blockquote">
    <p class="mb-0">Asignaturas que imparte cada docente.</p>
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
<button type="button" class="btn btn-success btn-custom" data-toggle="modal" data-target="#docentesAsignatura">+ Nuevo</button>
<div class="spacer"></div>
<div class="modal fade bd-example-modal-sm" id="docentesAsignatura" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ingrese</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{url('docentesAsignatura/insertar')}}" method="post">
                        @csrf
                 <!-- INICIO --->
                 <div class="mb-3 mt-3">
                    <label for="COD_DOCENTE" class="form-label">Docentes: </label>
                    <select class="selectize" id="COD_DOCENTE" name="COD_DOCENTE" required>
                        <option value="" disabled selected>Seleccione Docente</option>
                        @foreach ($docentesArreglo as $docentes)
                                <option value="{{ $docentes['COD_DOCENTE'] }}">{{ $docentes['NOMBRE_DOCENTE'] }}</option>
                        @endforeach
                    </select>
                </div>

                        <div class="mb-3 mt-3">
                    <label for="docentesAsignatura" class="form-label">Asignatura: </label>
                    <select class="selectize" id="COD_ASIGNATURA" name="COD_ASIGNATURA" required>
                        <option value="" disabled selected>Seleccione un docente</option>
                        @foreach ($asignaturasArreglo as $asignaturas)
                                <option value="{{ $asignaturas['COD_ASIGNATURA'] }}">{{ $asignaturas['NOMBRE_ASIGNATURA'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3 mt-3">
                    <label for="docentesAsignatura" class="form-label">Horas Semanales</label>
                    <input type="text" class="form-control" id="HORAS_SEMANALES" name="HORAS_SEMANALES" placeholder="Ingrese horas semanales" pattern="^(?:[1-9]|[1-4][0-9]|40)$" title="Máximo de horas 40"  oninput="this.value = this.value.replace(/[^0-9]/g, '').substr(0, 2);" required maxlength="2">
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
                <th>Nombre Completo</th>
                <th>Asignatura</th>
                <th>Horas Semanales</th>
                <th>Opciones Tabla</th>
            </tr>
        </thead>
        <tbody>
            @foreach($docentesAsignaturaArreglo as $docentesAsignatura)
              @php
                    $docentes = null;
                    foreach ($docentesArreglo as $d) {
                        if ($d['COD_DOCENTE'] === $docentesAsignatura['COD_DOCENTE']) {
                            $docentes = $d;
                            break;
                        }
                    }
                @endphp 
              @php
                    $asignaturas = null;
                    foreach ($asignaturasArreglo as $a) {
                        if ($a['COD_ASIGNATURA'] === $docentesAsignatura['COD_ASIGNATURA']) {
                            $asignaturas = $a;
                            break;
                        }
                    }
                @endphp 
            <tr>
                <td>{{ $docentesAsignatura['COD_DOCENTE_ASIGNATURA'] }}</td>
                <td>
                        @if ($docentes !== null)
                            {{ $docentes['NOMBRE_DOCENTE']}}
                        @else
                            Persona no encontrada
                        @endif
                    </td>
                    <td>
                        @if ($asignaturas !== null)
                            {{ $asignaturas['NOMBRE_ASIGNATURA']}}
                        @else
                            No encontrada
                        @endif
                    </td>
                  
               
                    <td>{{ $docentesAsignatura['HORAS_SEMANALES'] }}</td>
                <td>
                    <button value="Editar" title="Editar" class="btn btn-outline-info" type="button" data-toggle="modal"
                        data-target="#docentesAsignatura-edit-{{ $docentesAsignatura['COD_DOCENTE_ASIGNATURA'] }}">
                        <i class="fas fa-edit" style="font-size: 13px; color: cyan;"></i> Editar
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@foreach($docentesAsignaturaArreglo as $docentesAsignatura)
<div class="modal fade bd-example-modal-sm" id="docentesAsignatura-edit-{{ $docentesAsignatura['COD_DOCENTE_ASIGNATURA'] }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualiza Docente</h5>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{ url('docentesAsignatura/actualizar') }}" method="post">
                        @csrf
                        <input type="hidden" class="form-control" name="COD_DOCENTE_ASIGNATURA" value="{{ $docentesAsignatura['COD_DOCENTE_ASIGNATURA'] }}">
                        <div class="mb-3 mt-3">
                            <label for="docentesAsignatura" class="form-label">Asignaturas: </label>
                            <select class="selectize" id="COD_ASIGNATURA" name="COD_ASIGNATURA" required>
                                <option value="" disabled selected>Seleccione</option>
                                @foreach ($asignaturasArreglo as $asignaturas)
                                    <option value="{{ $asignaturas['COD_ASIGNATURA'] }}"
                                        {{ $asignaturas['COD_ASIGNATURA'] == $docentesAsignatura['COD_ASIGNATURA'] ? 'selected' : '' }}>
                                        {{ $asignaturas['NOMBRE_ASIGNATURA'] }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="docentesAsignatura" class="form-label">Horas Semanales:</label>
                            <input type="text" class="form-control" id="HORAS_SEMANALES" name="HORAS_SEMANALES" placeholder="Ingrese las horas semanales" value="{{ $docentesAsignatura['HORAS_SEMANALES'] }}" pattern="^(?:[1-9]|[1-4][0-9]|40)$" title="Máximo de horas 40"  oninput="this.value = this.value.replace(/[^0-9]/g, '').substr(0, 2);" required maxlength="2">
               
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


@stop

