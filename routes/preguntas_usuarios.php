<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\preguntas_usuariosController;

Route::middleware(['checkToken', 'verificar.usuario'])->group(function () {
Route::get('',[preguntas_usuariosController::class,'pregunta_usuarios']);
//de aqui 
Route::post('/insertar',[preguntas_usuariosController::class,'nuevo_permiso']);
Route::post('/actualizar',[preguntas_usuariosController::class,'modificar_pregunta_usuario']);
//hasta aqui
});