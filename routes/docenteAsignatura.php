<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\docenteAsignaturaController;

Route::get('',[docenteAsignaturaController::class,'docenteAsignatura']);
//de aqui 
Route::post('/insertar',[docenteAsignaturaController::class,'nuevo_docenteAsignatura']);
Route::post('/actualizar',[docenteAsignaturaController::class,'modificar_docenteAsignatura']);
//hasta aqui