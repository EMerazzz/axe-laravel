<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\loginController;
use App\Http\Controllers\AXE\preguntas_usuarioController;


Route::get('',[loginController::class,'login']);
Route::post('',[loginController::class,'ingresar']);
Route::get('/logout',[loginController::class,'logout']);



Route::post('/usuario',[loginController::class,'existeUsuario']);
Route::post('/nuevaContrasena',[loginController::class,'cambiarContrasena']);
Route::post('/nueva_pregunta',[preguntas_usuarioController::class,'nueva_pregunta']);