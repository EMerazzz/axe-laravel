@extends('adminlte::page')

@section('title', 'Cambiar constraseña')
@section('content_header')
<style>
  .custom-blockquote {
    line-height: 0; /* Reducción de la altura */
    margin-top: -5px; 
    margin-bottom:-5px; /* Reducción del espacio inferior del bloquequote */
  }
</style>
<blockquote class="custom-blockquote">
    <p class="mb-0">Cambiar contraseña.</p>
</blockquote>
@stop

@section('content')
<div class="d-flex justify-content-end align-items-center">
    <button id="mode-toggle" class="btn btn-info ms-2">
        <i class="fas fa-adjust"></i> Cambiar Modo
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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #325d64; color:white;">
                    <h3 class="modal-title" id="messageModalLabel">Mensaje:</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background-color: #c8dbff;">
                    <center><h3 style="color: #333;">{{ session('message.text') }}</h3></center>
                </div>
            </div>
        </div>
    </div>
@endif




<form  id="passwordForm" action="{{ url('cambiarContrasena/nuevaContrasena')}}" method="POST">
    @csrf
    <div class="mb-3">
      <p>Usuario</p>
      <input type="text" value = "{{$UsuarioValue}}" class="form-control" name="USUARIO" readonly required >

      <label for="exampleInputEmail1" class="form-label">Contraseña</label>
      <input type="password" class="form-control" id="newPassword" name="CONTRASENA" placeholder="Ingresa tu contraseña">
       
      
    </div>
    <div class="mb-3">
      <label for="exampleInputPassword1" class="form-label">Confirmar contraseña</label>
      <input type="password" class="form-control"id="confirmPassword"   name="CONTRASENA" placeholder="Confirma tu contraseña">
    </div>

    @if(isset($mensaje) && $mensaje['type'] === 'error')
     <div  class="alert alert-success" class="form-text">{{ $mensaje['text'] }}</div>
    @endif
    <button type="submit" class="btn btn-primary">Cambiar contraseña</button>


  </form>



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
 
    <!-- Script personalizado para validar los campos -->
 <script>
    const passwordForm = document.getElementById('passwordForm');
    const newPasswordInput = document.getElementById('newPassword');
    const confirmPasswordInput = document.getElementById('confirmPassword');
    
    passwordForm.addEventListener('submit', function(event) {
      if (newPasswordInput.value !== confirmPasswordInput.value) {
        alert('Las contraseñas no coinciden');
        event.preventDefault();
      } else if (newPasswordInput.value.length < 8) {
        alert('La contraseña debe tener al menos 8 caracteres');
        event.preventDefault();
      } else if (!/[a-z]/.test(newPasswordInput.value) || !/[A-Z]/.test(newPasswordInput.value)) {
        alert('La contraseña debe contener al menos una letra minúscula y una mayúscula');
        event.preventDefault();
      } else if (!/\d/.test(newPasswordInput.value)) {
        alert('La contraseña debe contener al menos un número');
        event.preventDefault();
      } else if (!/[!@#$%^&*]/.test(newPasswordInput.value)) {
        alert('La contraseña debe contener al menos un carácter especial: !@#$%^&*');
        event.preventDefault();
      }
      // Puedes agregar más validaciones según tus requerimientos aquí
      
      // Si todo está en orden, el formulario se enviará
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