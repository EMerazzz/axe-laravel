<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\telefonosController;

Route::get('',[telefonosController::class,'telefonos']);
//de aqui 
Route::post('/insertar',[telefonosController::class,'nuevo_telefono']);
Route::post('/actualizar',[telefonosController::class,'modificar_telefono']);
//hasta aqui