<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\RbitacoraController;


Route::middleware(['checkToken', 'verificar.usuario'])->group(function () {
    Route::get('',[RbitacoraController::class,'Rbitacora']);
   
});