<?php

use App\Http\Controllers\XassidaController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Route;

Route::get('/xassidas',         [XassidaController::class, 'index']);
Route::post('/xassidas',        [XassidaController::class, 'store']);
Route::put('/xassidas/{id}',    [XassidaController::class, 'update']);
Route::delete('/xassidas/{id}', [XassidaController::class, 'destroy']);

Route::post('/pdfs',            [PdfController::class, 'upload']);
Route::delete('/pdfs/{id}',     [PdfController::class, 'destroy']);

Route::get('/settings/{key}',   [SettingController::class, 'show']);
Route::put('/settings/{key}',   [SettingController::class, 'update']);
