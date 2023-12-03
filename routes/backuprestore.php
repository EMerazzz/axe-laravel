<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AXE\BackupRestoreController;

Route::middleware(['checkToken', 'verificar.usuario:BACKUP'])->group(function () {
    Route::get('',[BackupRestoreController::class,'backuprestore']);
    Route::post('/nuevo',[BackupRestoreController::class,'backup']);
    Route::get('/download/{filename}', [BackupRestoreController::class, 'descargarBackup'])->name('backup.download');
    Route::delete('/delete/{filename}', [BackupRestoreController::class, 'deleteBackup'])->name('backup.delete');
    Route::delete('/delete-all', [BackupRestoreController::class, 'deleteAllBU'])->name('backup.delete-all');
    Route::get('/upload-sql', [BackupRestoreController::class, 'showUploadSQLForm'])->name('sqlform.submit');
    Route::post('/upload-sql', [BackupRestoreController::class, 'showUploadSQLForm'])->name('sqlform.submit');
    Route::post('/restaurar', [BackupRestoreController::class, 'restore'])->name('backup.restore');
    //hasta aqui
});

/*
route::middleware(['checkToken'])->group(function () {
    Route::get('',[BackupRestoreController::class,'backuprestore']);
    Route::post('/nuevo',[BackupRestoreController::class,'backup']);
    Route::get('/download/{filename}', [BackupRestoreController::class, 'descargarBackup'])->name('backup.download');
    Route::delete('/delete/{filename}', [BackupRestoreController::class, 'deleteBackup'])->name('backup.delete');
    Route::delete('/delete-all', [BackupRestoreController::class, 'deleteAllBU'])->name('backup.delete-all');
    Route::get('/upload-sql', [BackupRestoreController::class, 'showUploadSQLForm'])->name('sqlform.submit');
    Route::post('/upload-sql', [BackupRestoreController::class, 'showUploadSQLForm'])->name('sqlform.submit');
    Route::post('/restaurar', [BackupRestoreController::class, 'restore'])->name('backup.restore');
});
*/