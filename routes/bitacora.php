<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\bitacoraController;


Route::middleware(['checkToken', 'verificar.usuario'])->group(function () {
    Route::get('',[bitacoraController::class,'bitacora']);
   
});
