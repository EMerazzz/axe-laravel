<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\cambiar_contrasenaController;

Route::get('',[cambiar_contrasenaController::class,'mostrarContrasena']);

Route::post('/nuevaContrasena',[cambiar_contrasenaController::class,'changeContrasena']);
//de aqui 