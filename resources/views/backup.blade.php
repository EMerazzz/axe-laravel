{{-- resources/views/backup.blade.php --}}


@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

{{-- Muestra mensajes de error --}}
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
<!DOCTYPE html>
<html>
<head>
    <title>Backup</title>
</head>
<body>
  
    <h1>Crear una Copia de Seguridad</h1>
    <form action="{{ url('backup/create') }}" method="POST">
        @csrf
        <button type="submit">Crear Copia de Seguridad</button>
    </form>
</body>
</html>
