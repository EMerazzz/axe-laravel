@extends('adminlte::master')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema AXE</title>
    
    <!-- Incluye el CSS de Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Otros archivos de estilo aquí -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon"/>
    
    <style>
        /* Estilos personalizados */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        
        .main {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 80%; /* Ajusta el ancho según tu preferencia */
            margin: 0 auto; /* Centra el contenido horizontalmente */
        }
        
        .left-side,
        .right-side {
            width: 50%;
            padding: 20px;
            border-right: 1px solid #ddd; /* Agrega una línea divisora */
            box-sizing: border-box; /* Evita que el borde afecte el tamaño total */
        }
        
        .logo img {
            max-width: 350px; /* Ajusta el tamaño de la imagen */
            margin-left: 150px; /* Separación de la izquierda */
        }
        
        .quote {
            font-size: 35px;
            color: #fff;
            margin-top: 20px;
        }
        
        .btn-primary {
            margin-top: 20px;
            margin-left: 230px; /* Separación de la izquierda */
            background-color: #28a745;
            border-color: #28a745;
        }
        
        .sistema-axe {
            font-size: 50px;
            font-weight: bold;
            color: #f0f0f0;
            margin-bottom: 00px;
            margin-top: 20px;
        }
        
        /* Estilos para dispositivos móviles */
        @media (max-width: 767px) {
            .main {
                flex-direction: column;
            }
            
            .left-side,
            .right-side {
                width: 100%;
                border-right: none;
            }
            
            .logo img {
                margin-left: 0;
                margin-right: 0;
            }
            
            .btn-primary {
                margin-left: 0;
            }
        }
    </style>
</head>

@section('body')
    <div class="main">
        <div class="left-side">
            <div class="sistema-axe">
                <center> Bienvenido</center> 
            </div>
            <div class="logo">
                <img src="{{ asset('7750e9a1-de96-4e9c-a66d-c243a9eb7b33-removebg-preview.png') }}" alt="Logo">
            </div>
        </div>
        <div class="right-side">
            <div class="quote">
                <center><p>"La educación es el arma más poderosa que puedes usar para cambiar el mundo." - Nelson Mandela</p></center>   
            </div>
            <div id="btn-primary">
                <a href="{{ url('login') }}" class="btn btn-primary btn-lg">Ingresar al sistema</a>
            </div>
        </div>
    </div>
@stop
