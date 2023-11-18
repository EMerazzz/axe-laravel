<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <!-- Scripts de Bootstrap y otros aquí -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Scripts de Bootstrap y otros aquí -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Agrega las hojas de estilo de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* Estilos personalizados */
        .error-message {
            display: none;
            position: absolute;
            background-color: #f44336;
            color: white;
            padding: 5px;
            border-radius: 5px;
            z-index: 1;
            margin-top: -30px;
        }
        
        .input-container {
            position: relative;
        }
        
        /* Estilos para dispositivos móviles */
        @media (max-width: 767px) {
            .main {
                padding: 10px;
            }
            
            .logo img {
                max-width: 150px;
            }
        }
    </style>
        <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            cursor: pointer;
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
                                <h3 class="login-heading" style="color: white;">Iniciar Sesión</h3> 
                                <div class="input-container">
                                    <span class="fa fa-user"></span>
                                    <input type="text" placeholder="Nombre de usuario"  name="USUARIO" oninput="convertToUppercaseAndValidate(this)"  required>
                                    <div class="error-message" id="error-message">No se permiten números en el usuario.</div>
                                </div>
                                <div class="password-container">
                                    <p>
                                        <span class="fa fa-lock"></span>
                                        <input id="password-input" type="password" placeholder="Contraseña" name="CONTRASENA" required>
                                        <i class="fa fa-eye toggle-password" onclick="togglePassword()"></i>
                                    </p>
                                </div>
                                <!-- Agrega el enlace de recuperación de contraseña -->
                                <p><a href="#" id="forgot-password-link" style="color: white;">¿Olvidaste tu contraseña?</a></p>
                                <div class="buttons-container d-flex justify-content-between align-items-center">
                                    <div>
                                        <button type="submit" class="btn btn-primary custom-btn">Iniciar sesión</button>
                                    </div>
                                </div>
                                @if(session('errorMessage'))
                                    <div class="text-white font-weight-bold">
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

    <script>
    function togglePassword() {
        var passwordInput = document.getElementById("password-input");
        var toggleIcon = document.querySelector(".toggle-password");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        } else {
            passwordInput.type = "password";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        }
    }
</script>
    <!-- Modal de Recuperación de Contraseña -->
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Recuperar contraseña</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Ingresa tu usuario:</p>
                    <form action="{{ url('login/usuario') }}" method="post">
                        @csrf
                        <input type="text" class="form-control" name="USUARIO" placeholder="Usuario" required
                        oninput="validarInput(this)">
                        <button type="submit" class="btn btn-primary mt-3">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Manejar el clic en el enlace "¿Olvidaste tu contraseña?"
        document.getElementById("forgot-password-link").addEventListener("click", function() {
            $('#forgotPasswordModal').modal('show');
        });
    </script>

    <script>
        function convertToUppercaseAndValidate(inputElement) {
            const errorMessage = document.getElementById("error-message");
            if (/\d/.test(inputElement.value)) {
                errorMessage.style.display = "block";
                inputElement.value = inputElement.value.toUpperCase().replace(/[0-9]/g, '');
            } else {
                errorMessage.style.display = "none";
                inputElement.value = inputElement.value.toUpperCase();
            }
        }
    </script>


<script>
document.addEventListener("DOMContentLoaded", function() {
  const usuarioInput = document.getElementById("usuarioInput");

  usuarioInput.addEventListener("input", function() {
    const inputValue = usuarioInput.value;
    const filteredValue = inputValue.replace(/[^a-zA-Z0-9]/g, ''); // Filtra caracteres no permitidos
    usuarioInput.value = filteredValue; // Actualiza el valor en el input
  });
});
</script>

<script>
    // Función para validar el contenido de un campo de entrada
    function validarInput(input) {
      const regex = /^[A-Za-z0-9]+$/; // Expresión regular para letras y números
      if (!regex.test(input.value)) {
        alert("El campo solo puede contener letras y números");
        input.value = ""; // Limpiar el campo
      }
    }
  </script>
    
</body>
</html>
