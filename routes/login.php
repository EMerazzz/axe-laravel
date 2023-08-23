<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\loginController;

Route::get('',[loginController::class,'login']);
Route::post('',[loginController::class,'ingresar']);
Route::get('/logout',[loginController::class,'logout']);



Route::post('/usuario',[loginController::class,'existeUsuario']);
Route::post('/nuevaContrasena',[loginController::class,'cambiarContrasena']);