@extends('adminlte::page')
@php
    use Carbon\Carbon;
@endphp

@section('title', 'Backup')

@section('content_header')
    <style>
        .custom-blockquote {
            line-height: 0;
            margin-top: -5px;
            margin-bottom: -5px;
        }
    </style>
    <blockquote class="custom-blockquote">
        <p class="mb-0">Backup - Restore</p>
    </blockquote>
@stop

@section('content')
    @if (session('notification'))
        @php
            $notification = session('notification');
        @endphp
        <div class="modal fade message-modal" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #325d64; color:white;">
                        <h3 class="modal-title" id="messageModalLabel">{{ $notification['title'] }}</h3>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="background-color: #c8dbff;">
                        <center><h3 style="color: #333;">{{ $notification['message'] }}</h3></center>
                    </div>
                </div>
            </div>
        </div>
        <!-- Solo carga jQuery una vez -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <!-- Otros scripts que utilizan jQuery -->
        <script>
            jQuery(document).ready(function () {
                $('#messageModal').modal('show');
            });
        </script>
    @endif

    <div class="button-container">
        <table>
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
                        <button type="submit" class="btn btn-sm btn-info" title="btnRestoreDatabase">
                            <i class="fa-solid fa-database" style='font-size:15px'></i> Restaurar
                        </button>
                    </form>
                </td>
                <td class="eliminar-todo" colspan="2" style="text-align: right;">
                    <!-- Agrega tu tercer botón aquí -->
                    <a href="#" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#confirmDelete-all">
                        <i class="fa fa-trash" style='font-size:15px'></i> Eliminar
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
                <div class="modal-body" style="background-color: #fff; padding: 20px;">
                    <div>¿Quieres eliminar todos los respaldos?</div>
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

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table id="backuprestore" class="table table-hover table-light table-striped mt-1" style="border:2px solid lime;">
                    <thead>
                        <th>#</th>
                        <th>Nombre del Archivo</th>
                        <th>Funciones</th>
                    </thead>
                    <tbody>
                        @foreach($citaArreglo as $backuprestore)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
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
                                        <div class="modal-body" style="background-color: #fff; padding: 20px;">
                                            ¿Quiere eliminar este respaldo?
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
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/datatables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
@stop

@section('js')
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-1.13.6/b-2.4.1/b-html5-2.4.1/b-print-2.4.1/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#backuprestore').DataTable({
                responsive: true,
                lengthMenu: [10, 20, 30, 40, 50],
                language: {
                    // ... (tu configuración de idioma)
                },
                
                order: [[0, 'desc']],
                lengthMenu: [5, 10, 30, 50,100,200], // Opciones disponibles en el menú
            pageLength: 5, // Establece la longitud de página predeterminada en 5
            });

            // Agrega el evento de clic para los botones de descarga
            $('.btn-descargar').on('click', function() {
                const filename = $(this).data('filename');
                descargarBackup(filename);
            });

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


@stop
