<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\preguntas_usuarioController;

route::middleware(['checkToken'])->group(function () {
Route::get('',[preguntas_usuarioController::class,'pregunta_usuarios']);
//de aqui 
//Route::post('/insertar',[permisosController::class,'nuevo_permiso']);
Route::post('/actualizar',[preguntas_usuarioController::class,'modificar_pregunta_usuario']);
//hasta aqui
});