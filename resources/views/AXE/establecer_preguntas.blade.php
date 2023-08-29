<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preguntas</title>
    <!-- Scripts de Bootstrap y otros aquí -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Scripts de Bootstrap y otros aquí -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Agrega las hojas de estilo de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="{{ asset('css/custom.css') }}">-->

    <style>
        /* Estilos para el botón de recuperar contraseña */
        .recovery-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #3498db;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        
        .recovery-button:hover {
            background-color: #2980b9;
        }
    </style>
    <style>
    /* Estilos para el botón de abrir el modal */
    .open-modal-button {
        padding: 10px 20px;
        font-size: 16px;
    }
</style>



</head>
<body>
    <div class="main">
        <div class="container">
            <center>
                <div class="middle">
                    <div id="login">

                        <form action="{{ url('login/nueva_pregunta') }}" method="post">
                            @csrf
                            <fieldset class="clearfix">
                            <h3 class="login-heading" style="color: white;">Establecer preguntas</h3> 

                            <p style="color: white; " ><em>{{$Usuario}}</em></p>

                            
                            <div class="form-group">
                                
                        <label for="pregunta1Respuesta" style="color: white; " >Pregunta </label>
                        <input type="text" class="form-control" id="pregunta1"  name= "PREGUNTA" style= "width: 115%; height: 30px;"  oninput="validarInput(this)" >
                        <label for="pregunta2Respuesta" style="color: white;">Respuesta</label>
                        <input type="text" class="form-control" id="respuesta1"  name= "RESPUESTA" style="width: 115%; height: 30px;"  oninput="validarInput(this)" >
                       
                        <div>
                            <button type="submit" class="open-modal-button btn btn-primary" data-toggle="modal" >Guardar</button>
                        </div>
                    </div>                      
                  
                    <div class="text-white font-weight-bold">
                        <br>
                        <p>{{ $mensaje }}</p>
                    </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="logo">
                        <img src="{{ asset('7750e9a1-de96-4e9c-a66d-c243a9eb7b33-removebg-preview.png') }}" style="max-width: 200px;">
                        <div class="clearfix"></div>
                    </div>
                </div>
            </center>
        </div>
    </div>    

   <!-- Modal de Recuperación de Contraseña -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" id="cambiarContrasenaHeader" disabled>
                <h4 class="modal-title">Cambiar contraseña</h4>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            


            <div class="modal-body">
            <form id="passwordForm" action="{{ url('login/nuevaContrasena') }}" method="post">
                <p>Usuario</p>
                <input type="text" value = "{{$Usuario}}" class="form-control" name="USUARIO" readonly required >
                <p>Escribe tu nueva contraseña:</p>
                <input type="password" class="form-control" id="newPassword" name="CONTRASENA" placeholder="Contraseña" required>    
                <p>Confirma tu contraseña:</p>
                <input type="password" class="form-control" id="confirmPassword" placeholder="Confirma Contraseña" required>
                <span id="message" style="color: red;"></span>


                    @csrf
                    <button type="submit" class="btn btn-primary mt-3">Enviar</button>
                </form>
            </div>
        </div>
    </div>

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
      }else{
        alert('Contraseña actualizada exitosamente');
      }
      // Puedes agregar más validaciones según tus requerimientos aquí
      
      // Si todo está en orden, el formulario se enviará
    });
    
      
</script>

<script>
    // Obtener una referencia al botón
    const loginButton = document.getElementById('openModalButton');
    
    // Agregar un event listener para el clic en el botón
    loginButton.addEventListener('click', function() {
        // Coloca aquí el código que deseas que se ejecute al hacer clic en el botón
        alert("¡Tu contraseña debe contener números, mayúsculas, minúsculas y caracteres especiales!");
    });
</script>

<script>
    const newPasswordInput = document.getElementById("newPassword");
    const confirmPasswordInput = document.getElementById("confirmPassword");
    const message = document.getElementById("message");

    confirmPasswordInput.addEventListener("keyup", () => {
        if (newPasswordInput.value !== confirmPasswordInput.value) {
            message.textContent = "Las contraseñas no coinciden";
        } else {
            message.textContent = "";
        }
    });

   document.querySelector("#forgotPasswordModal form").addEventListener("submit", (event) => {
    if (newPasswordInput.value !== confirmPasswordInput.value) {
        event.preventDefault();
        message.textContent = "Las contraseñas no coinciden. No se puede cambiar la contraseña.";
    } else {
        message.textContent = ""; // Reiniciar el mensaje de error si las contraseñas coinciden
    }
});
</script>
    <script>
    // Manejar el clic en el enlace "¿Olvidaste tu contraseña?"
    document.getElementById("forgot-password-link").addEventListener("click", function() {
        $('#forgotPasswordModal').modal('show');
    });

    // Cambiar el color del enlace
    document.getElementById("forgot-password-link").style.color = "white"; // Cambia el color a rojo
</script>

<!-- Agrega tu script -->

<script>
    // Función para validar el contenido de un campo de entrada
    function validarInput(input) {
        const regex = /^[A-Za-z0-9\s]*$/; // Expresión regular para letras, números y espacios

        // Obtener el evento del teclado
        const event = window.event || arguments.callee.caller.arguments[0];

        // Verificar si la tecla presionada es 'Delete' o 'Backspace'
        if (event.key === 'Delete' || event.key === 'Backspace') {
            // Verificar si el campo está vacío o solo tiene un carácter
            if (input.value.length <= 1) {
                return; // No se realiza la validación ni se muestra la alerta
            }
        }

        if (!regex.test(input.value)) {
            alert("El campo solo puede contener letras, números y espacios");
            input.value = ""; // Limpiar el campo
        }
    }
</script>


<!-- Coloca este fragmento en el lugar correspondiente de tu HTML -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var TOTALPREGUNTAS = {{ $TOTALPREGUNTAS }}; // Asigna el valor de TOTALPREGUNTAS desde PHP

        if (TOTALPREGUNTAS > 1) {
            makeInputsReadOnly();
            disableSubmitButton();

            document.addEventListener('click', function() {
            $('#forgotPasswordModal').modal('show');
            });

        }
        // Agregar el listener para mostrar el modal al hacer clic en la pantalla

    function makeInputsReadOnly() {
        document.getElementById('pregunta1').readOnly = true;
        document.getElementById('respuesta1').readOnly = true;
    }

    function disableSubmitButton() {
        var submitButton = document.querySelector('button[type="submit"]');
        if (submitButton) {
            submitButton.disabled = true;
        }
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var TOTALPREGUNTAS = {{ $TOTALPREGUNTAS }}; // Asigna el valor de TOTALPREGUNTAS desde PHP

        if (TOTALPREGUNTAS > 1) {
            document.addEventListener('click', function() {
            $('#forgotPasswordModal').modal('show');
        });
        }
        // Agregar el listener para mostrar el modal al hacer clic en la pantalla
    });
</script>

</body>
</html>