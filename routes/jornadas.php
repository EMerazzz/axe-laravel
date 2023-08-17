<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\jornadasController;

Route::get('',[jornadasController::class,'jornadas']);
//de aqui 
Route::post('/insertar',[jornadasController::class,'nueva_jornada']);
Route::post('/actualizar',[jornadasController::class,'modificar_jornada']);
//hasta aqui