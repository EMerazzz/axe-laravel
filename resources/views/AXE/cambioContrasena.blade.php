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
                <div class="middle">
                    <div id="login">
                        <form action="{{ url('login') }}" method="post">
                            @csrf
                            <fieldset class="clearfix">
                            <h3 class="login-heading" style="color: white;">Restablecer contraseña</h3> 

                                
                            <div class="form-group">
    <label for="pregunta1Respuesta">Respuesta a la pregunta 1:</label>
    <input type="text" class="form-control" id="pregunta1Respuesta"style="width: 200px; height: 30px;">
</div>

<div class="form-group">
    <label for="pregunta2Respuesta">Respuesta a la pregunta 2:</label>
    <input type="text" class="form-control" id="pregunta2Respuesta"style="width: 200px; height: 30px;">
</div>

                        <div class="form-group">
                            <button type="button" class="btn btn-primary" id="checkAnswersButton">Verificar respuestas</button>
                        </div>
                            
                        <div>
                            <button type="button" class="open-modal-button btn btn-primary" id="openModalButton" disabled>Recuperar contraseña</button>
                        </div>


                                @if(session('errorMessage'))
                                    <div  class="text-white font-weight-bold">
                                    <br>
                                    <p>{{ session('errorMessage') }}</p>
                                    </div>
                                @endif
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
    <!-- Modal de Recuperación de Contraseña -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cambiar contraseña</h4>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>


            <div class="modal-body">
            <form action="{{ url('login/nuevaContrasena') }}" method="post">
                <p>Usuario</p>
                <input type="text" value = "{{$variable}}" class="form-control" name="USUARIO" placeholder="Contraseña" readonly required>
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