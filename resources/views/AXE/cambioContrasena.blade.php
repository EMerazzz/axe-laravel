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
                                <p><span class="fa fa-user"></span><input id="username-input" type="text" placeholder="Nombre de usuario" name="USUARIO" required></p>
                                <p><span class="fa fa-lock"></span><input id="password-input" type="password" placeholder="Contraseña" name="CONTRASENA" required></p>
                                <!-- Agrega el enlace de recuperación de contraseña -->
                                <p><a href="#" id="forgot-password-link">¿Olvidaste tu contraseña?</a></p>
                                <div class="buttons-container d-flex justify-content-between align-items-center">
            
                                    <div>
                                        <button type="submit" class="btn btn-primary custom-btn">Iniciar sesión</button>
                                    </div>
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
<div class="modal fade" id="forgotPasswordModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Cambiar contraseña</h4>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="close"></button>
            </div>


            <div class="modal-body">
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
            message.innerHTML = "Las contraseñas no coinciden.<br>No se puede cambiar la contraseña.";
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

</body>
</html>