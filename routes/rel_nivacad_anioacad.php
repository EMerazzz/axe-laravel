<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\rel_nivacad_anioacadController;


Route::middleware(['checkToken'])->group(function () {
    Route::get('',[rel_nivacad_anioacadController::class,'rel_nivacad_anioacad']);
    //de aqui 
    Route::post('/insertar',[rel_nivacad_anioacadController::class,'insertarRelacionNivAcadAnioAcad']);
    Route::post('/actualizar',[rel_nivacad_anioacadController::class,'modificar_rel_nivacad_anioacad']);
});