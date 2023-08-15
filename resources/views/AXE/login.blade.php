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
	<link rel="stylesheet" href="{{ asset('css/custom.css') }}">

  
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
                                <p><span class="fa fa-user"></span><input id="username-input" type="text" placeholder="Nombre de usuario" name="USUARIO" required></p>
                                <p><span class="fa fa-lock"></span><input id="password-input" type="password" placeholder="Contraseña" name="CONTRASENA" required></p>
                            
								<div class="buttons-container d-flex justify-content-between align-items-center">
                                    <div>
                                        <a href="javascript:void(0);" class="btn btn-primary custom-btn" data-toggle="modal" data-target="#registroModal">Crear cuenta</a>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary custom-btn">Iniciar sesión</button>
                                    </div>
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

    <!-- Modal de Registro -->
	<div class="modal fade bd-example-modal-sm" id="registroModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Crear cuenta</h4>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5><p>Ingrese los Datos:</p></h5>
            </div>
            <div class="modal-footer">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <form action="{{ url('#') }}" method="post">
                        @csrf
                        <!-- Agregar los campos del formulario -->
					<div class="mb-3 mt-3">
						<label for="nombre" class="form-label">Nombre</label>
						<input type="text" class="form-control same-width" id="nombre" name="nombre" placeholder="Ingrese su nombre" required>
					</div>

					<div class="mb-3 mt-3">
						<label for="email" class="form-label">Correo Electrónico</label>
						<input type="email" class="form-control custom-textarea" id="email" name="email" placeholder="Ingrese su correo electrónico" required>
					</div>

					<div class="mb-3 mt-3">
						<label for="password" class="form-label">Contraseña</label>
						<input type="password" class="form-control custom-textarea" id="password" name="password" placeholder="Ingrese su contraseña" required>
					</div>


                                <!-- Agregar más campos si es necesario -->
                        <button type="submit" class="btn btn-primary">Registrar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


</body>
</html>

