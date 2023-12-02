@extends('adminlte::page')

@section('title', 'Restore')

@section('content')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div class="container">
        <h2>Subir archivo SQL para restaurar la base de datos</h2>

        @if(session('notification'))
            <div class="alert alert-{{ session('notification.type') }}">
                <strong>{{ session('notification.title') }}</strong> {{ session('notification.message') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ url('backuprestore/restaurar') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="backupFile">Seleccionar archivo .SQL:</label>
                <input type="file" name="backupFile" class="form-control" accept=".sql" required>
            </div>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Restaurar</button>
                <a href="{{ url('backuprestore') }}" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </div>
  

@endsection