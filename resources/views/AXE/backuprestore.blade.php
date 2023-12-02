@extends('adminlte::page')
@php
    use Carbon\Carbon;
@endphp

@section('title', 'Backup')

@section('content_header')
   
            <center><br>
                <h1>Backup - Restore</h1>
            </center></br>

 @section('content')

        <div class="button-container">
        
                <tr>
                    <td>
                        <form method="POST" action="{{ url('backuprestore/nuevo') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="fa-solid fa-plus" style='font-size:15px'></i> Nuevo
                            </button>
                        </form>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('sqlform.submit') }}">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-warning" title="btnRestoreDatabase">
                            <i class="fa-solid fa-database" style='font-size:15px'></i> Restaurar
                            </button>
                        </form>
                    </td>
                    <td class="eliminar-todo" colspan="2" style="text-align: right;">
                        <!-- Agrega tu tercer botón aquí -->
                        <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirmDelete-all">
                            <i class="fas fa-exclamation-triangle" style='font-size:15px'></i> Eliminar
                        </a>
                    </td>
                </tr>
            </table>
            
        </div>
        <!-- Modal para borrar todos -->
        <div class="modal fade" id="confirmDelete-all" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteLabel">Confirmar Eliminación</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        ¿Está seguro de querer eliminar todos los respaldos? Esta acción no se puede revertir.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <form id="deleteForm" action="{{ url('backuprestore/delete-all') }}" method="post" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mensaje de error cuando el rol este repetido -->
        @if(session('message'))
            <div class="alert alert-danger">
                {{ session('message')['text'] }}
            </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger" role="alert">
            <div class="text-center">
                <strong>Error:</strong> {{ session('error') }}
            </div>
        </div>
        @endif
            
            <div class="card">
                <div class="card-body">
                <div class="table-responsive">
                 <table id="backuprestore" class="table table-hover table-light table-striped mt-1" style="border:2px solid lime;">           
                        <thead>
                            <th><center>Nº</center></th>
                            <th><center>Nombre del Archivo</center></th>
                            <th><center><i class="fas fa-cog"></i></center></th>
                        </thead>
                        <tbody>
                            @foreach($citaArreglo as $backuprestore)
                                <tr>
                                    <td><center>{{ $loop->iteration }}</center></td>
                                    <td>{{ $backuprestore }}</td>
                                    <td>
                                    <a href="{{ url('backuprestore/download/' . $backuprestore) }}" class="btn btn-sm btn-info" title="Descargar">
                                        <i class="fa-solid fa-download" style='font-size:15px'></i>
                                    </a>
                                    <a href="#" class="btn btn-sm btn-danger" title="Eliminar" data-toggle="modal" data-target="#confirmDelete" onclick="updateDeleteForm('{{ $backuprestore }}')">
                                        <i class="fa-solid fa-trash" style='font-size:15px'></i> 
                                    </a>
                                    </td>
                                </tr>
                                <!-- Modal -->
                                <div class="modal fade" id="confirmDelete" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmDeleteLabel">Confirmar Eliminación</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                ¿Está seguro de querer eliminar este respaldo? Esta acción no se puede revertir.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <form id="deleteForm2" action="{{ url('backuprestore/delete/') }}" method="post" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    function updateDeleteForm(filename) {
                                        document.getElementById('deleteForm2').action = "{{ url('backuprestore/delete/') }}" + '/' + filename;
                                    }
                                </script>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @if(session('notification'))
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                        <script>
                            Swal.fire({
                                icon: '{{ session('notification')['type'] }}',
                                title: '{{ session('notification')['title'] }}',
                                text: '{{ session('notification')['message'] }}',
                            });
                        </script>
            @endif
      
        @stop

      @section('css')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="/css/admin_custom.css">
        <style>
            .button-container {
                display: inline-block;
            }

            .button-container a,
            .button-container form {
                display: inline-block;
                margin-right: 10px; /* Puedes ajustar este valor según sea necesario para el espacio entre los botones */
            }
            #paramtbl thead th {
                white-space: nowrap; /* Evita que el texto se divida en varias líneas */
                overflow: hidden; /* Oculta el desbordamiento del texto */
                text-overflow: ellipsis; /* Agrega puntos suspensivos al final si el texto es demasiado largo */
                max-width: 200px; /* Establece un ancho máximo para las celdas del encabezado */
            }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <!-- Agrega este enlace en el head de tu documento HTML -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    @stop

        @section('js')
        <script> console.log('Hi!'); </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
            <script> console.log('Hi!'); </script>
            <script>
                <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
                <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
                <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
                <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
                <script>
                $(document).ready(function() {
                    (function() {
                    $('#backuprestores').DataTable({
                        responsive: true,
                        lengthMenu: [10, 20, 30, 40, 50],
                        language: {
                            processing: "Procesando...",
                            lengthMenu: "Mostrar _MENU_ registros",
                            zeroRecords: "No se encontraron resultados",
                            emptyTable: "Ningún dato disponible en esta tabla",
                            info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
                            infoFiltered: "(filtrado de un total de _MAX_ registros)",
                            search: "Buscar:",
                            infoThousands: ",",
                            loadingRecords: "Cargando...",
                            paginate: {
                                first: "Primero",
                                last: "Último",
                                next: "Siguiente",
                                previous: "Anterior",
                            },
                            buttons: {
                                copy: "Copiar",
                                colvis: "Visibilidad",
                                collection: "Colección",
                                colvisRestore: "Restaurar visibilidad",
                                copyKeys: "Presione ctrl o u2318 + C para copiar los datos de la tabla al portapapeles del sistema. <br \/> <br \/> Para cancelar, haga clic en este mensaje o presione escape.",
                                copySuccess: {
                                    1: "Copiada 1 fila al portapapeles",
                                    _: "Copiadas %ds fila al portapapeles",
                                },
                                pdf: "PDF",
                                print: "Imprimir",
                            },
                        },
                        order: [[0, 'desc']],
                        columnDefs: [
                            { width: '1%', targets: [0] },
                            { width: '100%', targets: [0] },
                        ],
                    });
                    // Agrega el evento de clic para los botones de descarga
                    $('.btn-descargar').on('click', function() {
                        const filename = $(this).data('filename');
                        descargarBackup(filename);
                    });
                })();
                    // Función para descargar el archivo de respaldo
                    function descargarBackup(filename) {
                        // Construir la URL de descarga usando el nombre de archivo
                        const url = `{{ url('/SEGURIDAD/DESCARGAR-BACKUP') }}/${filename}`;

                        // Crear un enlace temporal y simular el clic para iniciar la descarga
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = filename;
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    }
                });
                </script>
            </script> 
            
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
            <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/datatables.min.js"></script>

            <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
        @stop
        @stop


