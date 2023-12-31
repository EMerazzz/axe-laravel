<?php

use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
route::middleware(['checkToken'])->group(function () {
Route::get('/', function () {
    return view('AXE/AXE');

Route::get('/backup', 'BackupController@index');

});
});
Route::get('/texto', function(){
    return '<h1>esto es un texto de prueba</h1>';
});


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/AXE', function () {
        return redirect('AXE');
    })->name('AXE');
});

