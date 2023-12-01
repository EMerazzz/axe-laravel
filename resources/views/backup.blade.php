@extends('adminlte::page')

@section('title', 'backup')

@section('content_header')
    <style>
        .custom-blockquote {
            line-height: 0; /* Reducción de la altura */
            margin-top: -5px;
            margin-bottom: -5px; /* Reducción del espacio inferior del bloquequote */
        }
    </style>
      <style>
  /* Estilo para el botón de Crear Backup */
.container button {
    background-color: #4caf50;
    color: white;
    border: none;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border-radius: 4px;
    transition: background-color 0.3s ease;
}

.container button:hover {
    background-color: #45a049;
}

/* Estilo para mensajes de éxito */
.success {
    color: green;
}

/* Estilo para mensajes de error */
.error {
    color: red;
}
</style>

@stop

@section('content')
    <!-- <blockquote class="custom-blockquote"> 
        <p class="mb-0"><strong>Backup</strong></p>
    </blockquote>-->

    <div class="container">
        <h1>Crear Backup</h1>

        @if(session('success'))
            <p class="success">{{ session('success') }}</p>
        @endif

        @if(session('error'))
            <p class="error">{{ session('error') }}</p>
        @endif

        <form method="post" action="{{ url('backup/create') }}">
            @csrf
            <button type="submit">Crear Backup</button>
        </form>

     
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('/css/admin_custom.css') }}">
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
@stop
