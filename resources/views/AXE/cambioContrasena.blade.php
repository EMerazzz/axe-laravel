<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar contraseña</title>
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
                <div>
                    <div login>

                        <!-- Empieza formulario  -->
                        <form action="{{ url('login') }}" method="post">
                            @csrf
                            <fieldset class="clearfix">
                                <h3 class="login-heading" style="color: white;">Restablecer contraseña</h3>
                                <div class="logo" style="margin-bottom: -15px; margin-top: -30px;">
                                    <img src="{{ asset('7750e9a1-de96-4e9c-a66d-c243a9eb7b33-removebg-preview.png') }}" style="max-width: 120px;">
                                    <div class="clearfix"></div>
                                </div>
                                <p style="color: white;"><em>{{$variable}}</em></p>
                        
                                @php $totalPreguntas = count($preguntasUsuario); @endphp
                                @foreach($preguntasUsuario as $indice => $pregunta)
                                <div class="form-group row align-items-center">
                                    <label for="pregunta{{ $indice + 1 }}Respuesta" class="col-sm-3 col-form-label pl-4" style="color: white;">{{ $pregunta['PREGUNTA'] }}</label>
                                    <div class="col-sm-9">
                                        <input 
                                            type="text" 
                                            class="form-control pregunta-input" 
                                            id="pregunta{{ $indice + 1 }}Respuesta" 
                                            style="height: 40px; border-width: 2px;" 
                                            oninput="validarRespuesta('{{ $pregunta['RESPUESTA'] }}', '{{ $indice + 1 }}', '{{ $totalPreguntas }}')"
                                            @if($indice !== 0) disabled @endif
                                        >
                                    </div>
                                </div>
                                @endforeach
                                
                                <div class="form-group">
                                    <button type="button" class="open-modal-button btn btn-primary" data-toggle="modal" data-target="#forgotPasswordModal" id="openModalButton" disabled>Recuperar contraseña</button>
                                </div>
                        
                                @if(session('errorMessage'))
                                <div class="text-white font-weight-bold">
                                    <br>
                                    <p>{{ session('errorMessage') }}</p>
                                </div>
                                @endif
                            </fieldset>
                        </form>
                                            
                        
                        
                        <!-- Empieza formulario  -->
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
                <input type="text" value = "{{$variable}}" class="form-control" name="USUARIO" readonly required >
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


       <!-- Ojo  -->
       <script>
        function validarRespuesta(respuestaCorrecta, indice, totalPreguntas) {
            var valorIngresado = document.getElementById('pregunta' + indice + 'Respuesta').value;
            var inputField = document.getElementById('pregunta' + indice + 'Respuesta');
            var openModalButton = document.getElementById('openModalButton');
    
            // Comparar la longitud del valor ingresado con la longitud de la respuesta correcta
            if (valorIngresado.length === respuestaCorrecta.length && valorIngresado === respuestaCorrecta) {
                inputField.style.borderColor = 'green';
                
                // Deshabilitar el input actual si la respuesta es correcta
                inputField.disabled = true;
    
                // Habilitar el siguiente input si existe
                if (indice < totalPreguntas) {
                    var siguienteIndice = parseInt(indice) + 1;
                    var siguienteInput = document.getElementById('pregunta' + siguienteIndice + 'Respuesta');
                    siguienteInput.removeAttribute('disabled');
                    siguienteInput.focus();
                }
    
                // Si es la última pregunta y la respuesta es correcta, habilitar el botón
                if (indice == totalPreguntas && valorIngresado === respuestaCorrecta) {
                    openModalButton.removeAttribute('disabled');
                }
            } else {
                inputField.style.borderColor = 'red';
            }
        }
    </script>
    
    
   <!-- Modal de Recuperación de Contraseña -->
   <script>
    window.onload = function() {
        // Seleccionar todos los inputs con la clase "pregunta-input"
        var inputs = document.querySelectorAll('.pregunta-input');
        
        // Deshabilitar todos los inputs excepto el primero (índice 0)
        for (var i = 1; i < inputs.length; i++) {
            inputs[i].disabled = true;
        }

        // Deshabilitar el botón con id "openModalButton"
        var openModalButton = document.getElementById('openModalButton');
        openModalButton.disabled = true;
    };
</script>

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

<script>
    // ... Tu código actual ...


    // Define una variable para controlar si se respondieron las preguntas
    let answeredQuestions = false;
    // Función para habilitar el botón si se respondieron las preguntas
    function enableRecoveryButton() {
        answeredQuestions = true;
        document.getElementById("openModalButton").removeAttribute("disabled");
    }

    // Escucha las respuestas de las preguntas y habilita el botón si se respondieron
    document.getElementById("pregunta1Respuesta").addEventListener("change", function() {
        // Lógica para verificar respuesta
        if (/* Condición de respuesta correcta */) {
            enableRecoveryButton();
        }
    });

    document.getElementById("pregunta2Respuesta").addEventListener("change", function() {
        // Lógica para verificar respuesta
        if (/* Condición de respuesta correcta */) {
            enableRecoveryButton();
        }
    });

    // ... Tu código actual ...
</script>

<script>
    // ... Tu código actual ...

    // Manejar el clic en el enlace "¿Olvidaste tu contraseña?"
    document.getElementById("openModalButton").addEventListener("click", function() {
        if (answeredQuestions) {
            $('#forgotPasswordModal').modal('show');
        } else {
            // Mostrar mensaje o realizar alguna acción si no se respondieron las preguntas
        }
    });

    // ... Tu código actual ...
</script>
</body>
</html>