<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\estudiantesController;

Route::middleware(['checkToken', /*'verificar.usuario:MATRICULA'*/])->group(function () {
    Route::get('',[estudiantesController::class,'estudiantes']);

});