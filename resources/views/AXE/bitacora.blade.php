@extends('adminlte::page')

@section('title', 'Bitacoras')

@section('content_header')
<blockquote class="custom-blockquote">
    <p class="mb-0">Bitacora de el sistema AXE.</p>
   
</blockquote>
@stop

@section('content')
<div class="d-flex justify-content-end align-items-center">
    <button id="mode-toggle" class="btn btn-info ms-2 btn-with-margin">
        <i class="fas fa-adjust"></i> Cambiar Modo
    </button>
</div>
<style>
        /* Agrega margen derecho al botón */
        .btn-with-margin {
            margin-right: 10px; /* Ajusta el valor según tus necesidades */
            margin-bottom: 20px; /* Ajusta el valor según tus necesidades */
        }
    </style>

<div class="table-responsive">
<table id="miTabla" class="table table-hover table-light table-striped mt-1" style="border:2px solid lime;">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre Tabla</th>
                <th>Módulo tabla</th>
                <th>Tipo evento</th>
                <th>Fecha Registro</th>
                <th>Fecha Modificación</th>
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
                <td>{{ $bitacora['TIPO_EVENTO'] }}</td>
                <td>{{ date('Y-m-d', strtotime($bitacora['FECHA_REGISTRO'])) }}</td>
                <td>{{ date('d, M Y', strtotime($bitacora['FECHA_MODIFICACION'])) }}</td>
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



@stop